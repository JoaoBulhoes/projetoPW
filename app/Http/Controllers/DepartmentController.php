<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function store(Request $request)
    {
        $department = new Department();
        $department->name = $request->input('name');


        $department->save();

        return redirect()->route('departments.index')->with('success', 'Departamento criado com sucesso!');
    }

}

