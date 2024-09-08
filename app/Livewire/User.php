<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class User extends Component
{
    use WithFileUploads;
    use WithPagination;

    public UserModel $user;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $course = null;
    public $section = null;
    public string $role = 'student';
    public bool $isPanelChair = false;
    public array $sections = [];
    public $sortBySectionId = '';
    public string $panelistType = ''; //chair, member
    public bool $filterByAdmin = false;
    public bool $filterBySecretary = false;
    public string $expertType = '';
    public bool $filterByStudent = false;

    public $search = '';

    public $csvFile;

    public function mount()
    {
        $this->authorize('admin.read');
    }

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email|ends_with:my.cspc.edu.ph',
        'password' => 'required|confirmed|string',
        'course' => 'required_if:role,student|required_with:section',
        'section' => 'required_if:role,student|required_with:course',
        'role' => 'required|string'
    ];

    public function store()
    {
        $this->validate();

        $user = UserModel::create([
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => now(),
            'password' => bcrypt($this->password),
            'course_id' => $this->course,
            'section_id' => $this->section,
            'is_panel_chair' => $this->isPanelChair,
        ]);

        $user->assignRole($this->role);

        session()->flash('success', 'User created.');
        $this->redirect(User::class);
    }

    public function edit(UserModel $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->course = $user->course_id;
        $this->getSections();
        $this->role = $user->roles->pluck('name')[0];
        $this->isPanelChair = ($user->is_panel_chair) ? true : false;
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string',
            'email' => 'ends_with:my.cspc.edu.ph|required|email|unique:users,email,'.$this->user->id,
            'password' => 'sometimes|nullable|confirmed',
            'course' => 'nullable|required_if:role,student|required_with:section',
            'section' => 'nullable|required_if:role,student|required_with:course',
            'role' => 'required|string',
            'isPanelChair' => 'boolean',
        ]);

        $this->user->name = $validated['name'];
        $this->user->email = $validated['email'];
        $this->user->course_id = ($validated['course'] === '') ? null : $validated['course'];
        $this->user->section_id = ($validated['section'] === '') ? null : $validated['section'];
        if ( $validated['password'] != null || $validated['password'] != '')
        {
            $this->user->password = bcrypt($validated['password']);
        }
        $this->user->is_panel_chair = $validated['isPanelChair'];
        $this->user->syncRoles([$validated['role']]);

        $this->user->save();

        session()->flash('success', 'User updated.');

        $this->redirect(User::class);
    }

    public function destroy(UserModel $user)
    {
        if ($user->teams()->count() > 0) {
            return $this->addError('name', 'Cannot delete user that have team.');
        }

        $user->delete();

        session()->flash('success', 'User deleted.');

        $this->redirect(User::class);
    }

    public function checkRole()
    {
        if ($this->role === 'student')
        {
            $this->isPanelChair = false;
        }

        if ($this->role === 'panelist' || $this->role === 'expert')
        {
            $this->course = null;
            $this->section = null;
        }
    }

    public function uploadCsv()
    {
        $this->validate([
            'csvFile' => 'required|mimes:csv,txt|max:2048', // 2MB Max
        ]);

        $path = $this->csvFile->store('uploads');

        $file = Storage::get($path);

        $rows = array_map('str_getcsv', explode("\n", $file));

        $header = array_shift($rows);

        
        foreach ($rows as $row) {

            
            if (count($header) != count($row)) {
                continue;
            }

            $data = array_combine($header, $row);
            
            $validator = Validator::make($data, [
                'Name' => 'required|string|max:255',
                'Email' => 'required|email|unique:users,email|ends_with:my.cspc.edu.ph',
                'Role' => 'required|string',
                'Course' => 'required',
                'Section' => 'required'
            ]);

            if ($validator->fails()) {
                continue;
            }
            
            $user = UserModel::create([
                'name' => $data['Name'],
                'email' => $data['Email'],
                'password' => bcrypt('password'),
            ]);

            $user->assignRole($data['Role']);

        }

        session()->flash('success', 'Users uploaded');

        $this->redirect(User::class);
    }

    public function getSections()
    {
        if ($this->course != null)
        {
            $this->sections = [];
            $course = Course::find($this->course);
            foreach($course->sections as $section)
            {
                $this->sections[] = [
                    'id' => $section->id,
                    'name' => $section->name,
                ];
            }

        }
    }

    public function filterByAdminUsers()
    {
        $this->clearSorting();
        $this->filterByAdmin = true;
        $adminUsers = UserModel::role('admin')->paginate();

        return $adminUsers;
    }

    public function filterBySecretaryUsers()
    {
        $this->clearSorting();
        $this->filterBySecretary = true;
        $secretaryUsers = UserModel::role('secretary')->paginate();

        return $secretaryUsers;
    }

    public function filterByStudentUsers()
    {
        $this->clearSorting();
        $this->filterByStudent = true;
        $studentUsers = UserModel::role('student')->paginate();

        return $studentUsers;
    }

    public function sortBySection()
    {
        $exploadedCourseSectionId = explode(',', $this->sortBySectionId);

        $users = UserModel::role('student')
            ->where('course_id', $exploadedCourseSectionId[0])
            ->where('section_id', $exploadedCourseSectionId[1])
            ->with('teams')
            ->paginate();

        
        return $users;
    }

    public function sortByPanelist()
    {
        $isPanelChair = ($this->panelistType == 'chair') ? true : false;
        $users = UserModel::role('panelist')
            ->where('is_panel_chair', $isPanelChair)
            ->paginate();

        return $users;
    }

    public function filterByExpertUsers()
    {
        if ($this->expertType != '')
        {
            $users = UserModel::role($this->expertType)->paginate();
            return $users;
        }

        return;
    }

    public function clearSorting()
    {
        $this->sortBySectionId = '';
        $this->panelistType = '';
        $this->filterByAdmin = false;
        $this->filterBySecretary = false;
        $this->expertType = '';
        $this->filterByStudent = false;
        $this->resetPage();
    }

    public function clear()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->course = null;
        $this->section = null;
        $this->role = '';
        $this->isPanelChair = '';
        $this->sections = [];
        $this->sortBySectionId = '';
        $this->panelistType = '';
        $this->filterByAdmin = false;
        $this->filterBySecretary = false;
        $this->expertType = '';
        $this->filterByStudent = false;
        $this->resetValidation();
    }

    public function render()
    {
        // $users = UserModel::orderBy('name', 'asc')->with('course', 'section')->paginate();
        if ($this->sortBySectionId != '')
        {
            $users = $this->sortBySection();
        } elseif ($this->panelistType != '') {
            $users = $this->sortByPanelist();
        } elseif ($this->filterByAdmin) {
            $users = $this->filterByAdminUsers();
        } elseif ($this->filterBySecretary){
            $users = $this->filterBySecretaryUsers();
        } elseif ($this->expertType != '') {
            $users = $this->filterByExpertUsers();
        } elseif ($this->filterByStudent) {
            $users = $this->filterByStudentUsers();
        } else {
            $this->sortBySectionId = '';
            $users = UserModel::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->with('teams')
                ->paginate();
        }

        $courses = Course::orderBy('name', 'asc')->get();
        $roles = \Spatie\Permission\Models\Role::all();

        return view('livewire.user', [
            'users' => $users,
            'courses' => $courses,
            'roles' => $roles
        ]);
    }
}
