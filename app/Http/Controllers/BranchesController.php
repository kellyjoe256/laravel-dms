<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Http\Requests\AddBranchRequest;
use App\Http\Requests\EditBranchRequest;
use Illuminate\Http\Request;

class BranchesController extends Controller
{
    public function index()
    {
        $branches = Branch::selectRaw('
                branch_id, branch_name
            ')->orderByRaw('branch_name')
            ->paginate(env('PAGE_SIZE', 10));

        $data = [
            'title' => 'Branches',
            'branches' => $branches,
        ];

        return view('main/branches/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add Branch',
        ];

        return view('main/branches/create', $data);
    }

    public function store(AddBranchRequest $request)
    {
        $branch = new Branch;
        $branch->branch_name = $request->branch_name;
        $branch->save();

        return redirect()->route('branches')->with([
            'class' => 'alert-success',
            'message' => 'Branch added successfully',
        ]);
    }

    public function edit($branch_id)
    {
        $columns = ['branch_id', 'branch_name'];
        $branch = Branch::findOrFail((int) $branch_id, $columns);

        $data = [
            'title' => 'Edit Branch',
            'branch' => $branch,
        ];

        return view('main/branches/edit', $data);
    }

    public function update(EditBranchRequest $request, $branch_id)
    {
        $branch = Branch::findOrFail((int) $branch_id);

        if ($branch->branch_name != $request->branch_name) {
            $this->validate($request, [
                'branch_name' => 'unique:branch',
            ], [], ['branch_name' => 'Branch Name']);
        }

        $branch->branch_name = $request->branch_name;
        $branch->save();

        return redirect()->route('branches')->with([
            'class' => 'alert-success',
            'message' => 'Branch edited successfully',
        ]);
    }

    public function delete($branch_id)
    {
        $columns = ['branch_id', 'branch_name'];
        $branch = Branch::findOrFail((int) $branch_id, $columns);

        $data = [
            'title' => 'Delete Branch',
            'branch' => $branch,
        ];

        return view('main/branches/delete', $data);
    }

    public function destroy(Request $request, $branch_id)
    {
        if ($request->submit == 'Cancel') {
            return redirect()->route('branches');
        }

        $branch = Branch::findOrFail((int) $branch_id);

        $flash_message_attributes = [];
        if ($request->submit == 'Delete Branch') {
            $branch->delete();

            $flash_message_attributes = [
                'class' => 'alert-success',
                'message' => 'Branch deleted successfully',
            ];
        }

        return redirect()->route('branches')
            ->with($flash_message_attributes);
    }

    public function departments($branch_id)
    {
        $branch = Branch::findOrFail((int) $branch_id);
        $departments = $branch->departments
            ->pluck('department_name')->toArray();
        sort($departments);

        $data = [
            'title' => $branch->branch_name . ' Branch Departments',
            'branch' => $branch,
            'departments' => $departments,
        ];

        return view('main/branches/departments', $data);
    }

    public function addDepartments($branch_id)
    {
        $branch = Branch::findOrFail((int) $branch_id);
        $departments = Department::orderByRaw('department_name')
            ->get(['department_id', 'department_name']);
        $branch_departments = $branch->departments
            ->pluck('department_id')->toArray();

        $data = [
            'title' => 'Add Departments',
            'branch' => $branch,
            'departments' => $departments,
            'branch_departments' => $branch_departments,
        ];

        return view('main/branches/add_departments', $data);
    }

    public function storeDepartments(Request $request, $branch_id)
    {
        $this->validate($request, [
            'departments' => 'required|array|min:1',
        ], [
            'departments.required' => 'You must at least select one Department',
        ], ['departments' => 'Departments']);

        $branch = Branch::findOrFail((int) $branch_id);
        $branch->departments()->sync($request->departments);

        return redirect()->route('branches')->with([
            'class' => 'alert-success',
            'message' => 'Branch Departments added successfully',
        ]);
    }

    public function getDepartments($branch_id=0)
    {
        $departments = [];

        $branch = Branch::find((int)$branch_id);
        if ($branch) {
            $data = $branch->departments
                ->pluck('department_name', 'department_id')
                ->toArray();
            asort($data);

            foreach ($data as $key => $value) {
                array_push($departments, [
                    'id' => (int)$key,
                    'department' => $value,
                ]);
            }
        }

        return response(json_encode($departments), 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
