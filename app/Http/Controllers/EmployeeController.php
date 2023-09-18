<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function createEmployee(CreateEmployeeRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $employee = Employee::create($data);

        return response(new EmployeeResource($employee), 201);
    }
}
