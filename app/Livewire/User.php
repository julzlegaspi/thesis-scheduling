<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User as UserModel;

class User extends Component
{
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

    public $search = '';

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
        $this->section = $user->section_id;
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

        if ($this->role === 'panelist')
        {
            $this->course = null;
            $this->section = null;
        }

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
        $this->resetValidation();
    }

    public function render()
    {
        // $users = UserModel::orderBy('name', 'asc')->with('course', 'section')->paginate();
        $users = UserModel::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->with('teams')
            ->paginate();
        $courses = Course::orderBy('name', 'asc')->get();
        $sections = Section::orderBy('name', 'asc')->get();
        $roles = \Spatie\Permission\Models\Role::all();

        return view('livewire.user', [
            'users' => $users,
            'courses' => $courses,
            'sections' => $sections,
            'roles' => $roles
        ]);
    }
}
