<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public $allUsers;

    public string $pageTitle;

    public function __construct()
    {
        $this->allUsers = User::all();
        $this->pageTitle = __('Users');
    }

    public function index()
    {
        Gate::authorize('users_resources');

        $users = User::paginate();

        return view('layouts.admin_panel.users.index',
            [
                'page_title' => $this->pageTitle,
                'users' => $users,
            ]);
    }

    public function create()
    {
        Gate::authorize('users_resources');

        if ($this->allUsers->count() > 9) {

            return to_route('admin_panel.users.index')->with('error', __('Maximum registration limit reached.'));

        } else {

            return view('layouts.admin_panel.users.create',
                [
                    'page_title' => $this->pageTitle,
                ]);

        }
    }

    public function store(Request $request)
    {
        Gate::authorize('users_resources');

        $rules = [

            'name' => 'required|min:3|max:50',
            'email' => 'required|email|max:50|unique:users',
            'password' => ['required', 'max:15',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'password_confirmation' => [
                'same:password',
            ],

        ];

        $messages = [

            'password_confirmation.same' => __('Password does not match'),

        ];

        $request->validate($rules, $messages);

        try {

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            return response()->json(
                session()->flash('info', __('Successful registration.')),
                201
            );

        } catch (Exception $e) {

            return response()->json(
                // session()->flash('error', $e->getMessage()),
                session()->flash('error', __('Error creating record.')),
                500
            );

        }
    }

    public function edit(User $user)
    {
        Gate::authorize('users_resources');

        return view('layouts.admin_panel.users.edit',
            [
                'user' => $user,
                'page_title' => $this->pageTitle,
            ]);
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('users_resources');

        $rules = [

            'name' => 'required|min:3|max:50',
            'email' => 'required|email|max:50|unique:users,email,'.$user->id,
            'password_options' => 'not_in:select',
            'password' => ['exclude_unless:password_options,1', 'required', 'max:15',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'password_confirmation' => 'exclude_unless:password_options,1|same:password',

        ];

        $messages = [

            'password_confirmation.same' => __('Password does not match'),

        ];

        $request->validate($rules, $messages);

        try {

            if ($request->password_options == 1) {

                $user->update([

                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,

                ]);

            } else {

                $user->update([

                    'name' => $request->name,
                    'email' => $request->email,

                ]);

            }

            return response()->json(
                session()->flash('info', __('Updated successfully.')),
                201
            );

        } catch (Exception $e) {

            return response()->json(
                // session()->flash('error', $e->getMessage()),
                session()->flash('error', __('Error updating record.')),
                500
            );

        }
    }

    public function destroy(User $user)
    {
        Gate::authorize('users_resources');

        if ($user->is_admin) {

            return to_route('admin_panel.users.index')->with('error', __('Deleting the record is not allowed.'));

        } else {

            $user->delete();

            return to_route('admin_panel.users.index')->with('info', __('Record deleted.'));

        }
    }
}
