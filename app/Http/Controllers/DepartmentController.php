<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Document;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::orderBy('name')->paginate(25);
        return view(
            'departments.index',
            [
                'departments' => $departments
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userService = new UserService();
        $userService->can("create", Department::class);

        return view(
            'departments.create', []
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userService = new UserService();
        $userService->can("create", Department::class);

        $department = Department::create([
            'name' => $request->name
        ]);

        $department->save();
        return redirect()->route('departments.index');
    }

    /**
     * Display the specified resource.
     */
//    public function show(Department $department)
//    {
//        return view(
//            'departments.show',
//            [
//                'department' => $department
//            ]
//        );
//    }

    /**
     * Show the form for editing the specified resource.
     */
//    public function edit(string $id)
//    {
        //
//    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, string $id)
//    {
        //
//    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $userService = new UserService();
        $userService->can("delete", Department::class);

        $department->delete();
        return redirect()->route('departments.index');
    }
}
