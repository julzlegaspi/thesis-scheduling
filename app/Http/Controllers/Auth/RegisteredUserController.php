<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $tempUserExist = false;
        if (file_exists(storage_path('app/uploads/temp-users.csv')))
        {
            $tempUserExist = true;
            $tempUsersArray = [];

            $fullPath = storage_path('app/uploads/temp-users.csv');
                    // Open the file for reading
            if (($handle = fopen($fullPath, 'r')) !== false) {
                // Get the headers from the first row
                $headers = fgetcsv($handle);

                // Initialize an array to hold the data
                $data = [];

                // Loop through the file and parse each row
                while (($row = fgetcsv($handle)) !== false) {
                    $data[] = array_combine($headers, $row);
                }

                // Close the file
                fclose($handle);

                // Process the data
                foreach ($data as $row) {
                    // Your logic here
                    array_push($tempUsersArray, $row['Email']);
                }
            }
        }

        if (!$tempUserExist)
        {
            return back()->withErrors([
                'email' => 'Unable to register this email. Contact administrator.',
            ])->onlyInput('email');
        }

        if (!in_array($request->email, $tempUsersArray))
        {
            return back()->withErrors([
                'email' => 'Unable to register this email. Contact administrator.',
            ])->onlyInput('email');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'ends_with:my.cspc.edu.ph,cspc.edu.ph', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('student');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
