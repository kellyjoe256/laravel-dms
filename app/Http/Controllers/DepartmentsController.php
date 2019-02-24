<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Http\Requests\AddDepartmentRequest;
use App\Http\Requests\EditDepartmentRequest;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function index()
    {
        $departments = Department::selectRaw('
                department_id, department_name
            ')->orderByRaw('department_name')
            ->paginate(env('PAGE_SIZE', 10));

        $data = [
            'title' => 'Departments',
            'departments' => $departments,
        ];

        return view('main/departments/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add Department',
        ];

        return view('main/departments/create', $data);
    }

    public function store(AddDepartmentRequest $request)
    {
        $department = new Department;
        $department->department_name = $request->department_name;
        $department->save();

        return redirect()->route('departments')->with([
            'class' => 'alert-success',
            'message' => 'Department added successfully',
        ]);
    }

    public function edit($department_id)
    {
        $columns = ['department_id', 'department_name'];
        $department = Department::findOrFail((int) $department_id, $columns);

        $data = [
            'title' => 'Edit Department',
            'department' => $department,
        ];

        return view('main/departments/edit', $data);
    }

    public function update(EditDepartmentRequest $request, $department_id)
    {
        $department = Department::findOrFail((int) $department_id);

        if ($department->department_name != $request->department_name) {
            $this->validate($request, [
                'department_name' => 'unique:department',
            ], [], ['department_name' => 'Department Name']);
        }

        $department->department_name = $request->department_name;
        $department->save();

        return redirect()->route('departments')->with([
            'class' => 'alert-success',
            'message' => 'Department edited successfully',
        ]);
    }

    public function delete($department_id)
    {
        $columns = ['department_id', 'department_name'];
        $department = Department::findOrFail((int) $department_id, $columns);

        $data = [
            'title' => 'Delete Department',
            'department' => $department,
        ];

        return view('main/departments/delete', $data);
    }

    public function destroy(Request $request, $department_id)
    {
        if ($request->submit == 'Cancel') {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($department_id);

        $flash_message_attributes = [];
        if ($request->submit == 'Delete Department') {
            $department->delete();

            $flash_message_attributes = [
                'class' => 'alert-success',
                'message' => 'Department deleted successfully',
            ];
        }

        return redirect()->route('departments')
            ->with($flash_message_attributes);
    }

    public function branches($department_id)
    {
        $department = Department::findOrFail((int) $department_id);
        $branches = $department->branches
            ->pluck('branch_name')->toArray();
        sort($branches);

        $data = [
            'title' => $department->department_name . ' &ndash; Branches',
            'department' => $department,
            'branches' => $branches,
        ];

        return view('main/departments/branches', $data);
    }

    public function addBranches($department_id)
    {
        $department = Department::findOrFail((int) $department_id);
        $branches = Branch::orderByRaw('branch_name')
            ->get(['branch_id', 'branch_name']);
        $department_branches = $department->branches
            ->pluck('branch_id')->toArray();

        $data = [
            'title' => 'Add Branches',
            'department' => $department,
            'branches' => $branches,
            'department_branches' => $department_branches,
        ];

        return view('main/departments/add_branches', $data);
    }

    public function storeBranches(Request $request, $department_id)
    {
        $this->validate($request, [
            'branches' => 'required|array|min:1',
        ], [
            'branches.required' => 'You must at least select one Branch',
        ], ['branches' => 'Branches']);

        $department = Department::findOrFail((int) $department_id);
        $department->branches()->sync($request->branches);

        return redirect()->route('departments')->with([
            'class' => 'alert-success',
            'message' => 'Department Branches added successfully',
        ]);
    }
}
