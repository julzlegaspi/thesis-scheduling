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

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $course = null;
    public $section = null;
    public $role = '';

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
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string',
            'email' => 'ends_with:my.cspc.edu.ph|required|email|unique:users,email,'.$this->user->id,
            'password' => 'sometimes|nullable|confirmed',
            'course' => 'nullable|required_if:role,student|required_with:section',
            'section' => 'nullable|required_if:role,student|required_with:course',
            'role' => 'required|string'
        ]);

        $this->user->name = $validated['name'];
        $this->user->email = $validated['email'];
        $this->user->course_id = ($validated['course'] === '') ? null : $validated['course'];
        $this->user->section_id = ($validated['section'] === '') ? null : $validated['section'];
        if ( $validated['password'] != null || $validated['password'] != '')
        {
            $this->user->password = bcrypt($validated['password']);
        }
        $this->user->syncRoles([$validated['role']]);
        $this->user->save();

        session()->flash('success', 'User updated.');

        $this->redirect(User::class);
    }

    public function destroy(UserModel $user)
    {
        $user->delete();

        session()->flash('success', 'User deleted.');

        $this->redirect(User::class);
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
        $this->resetValidation();
    }

    public function render()
    {
        $users = UserModel::orderBy('name', 'asc')->with('course', 'section')->paginate();
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
