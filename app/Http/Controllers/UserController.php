<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Department;
use App\Models\Profile;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userService = new UserService();
        $userService->can("view", User::class);

        $users = User::orderBy('name')->paginate(25);
        return view(
            'users.index',
            [
                'users' => $users
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userService = new UserService();
        $userService->can("create", User::class);

        $departments = Department::all();
        $profiles = Profile::all();
        return view(
            'users.create',
            [
                'departments' => $departments,
                'profiles' => $profiles
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userService = new UserService();
        $userService->can("create", User::class);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        $user->departments()->attach($request->department_id);

        $user->profiles()->attach($request->profile_id);

        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $userService = new UserService();
        $userService->can("view", User::class);

        return view(
            'users.show',
            [
                'user' => $user
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $userService = new UserService();
        $userService->can("update", User::class);

        $departments = Department::all();
        $profiles = Profile::all();
        return view(
            'users.edit',
            [
                'user' => $user,
                'departments' => $departments,
                'profiles' => $profiles,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $userService = new UserService();
        $userService->can("update", User::class);

        $user->update([
            'name' => $request->name,
        ]);

        if (!$request->department_id || !$request->profile_id) {
            abort(404);
        }

        $user->departments()->detach($request->department_id);

        $user->profiles()->detach($request->profile_id);

        if ($request->add_department && !$user->departments->contains($request->department_id)) {
            $user->departments()->attach($request->department_id);
        }

        if ($request->add_profile && !$user->profiles->contains($request->profile_id)) {
            $user->profiles()->attach($request->profile_id);
        }

        $user->save();

        return redirect()->route('users.show', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $userService = new UserService();
        $userService->can("delete", User::class);

        $user->delete();
        return redirect()->route('users.index');
    }
}
