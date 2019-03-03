<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use App\Branch;
use App\Department;
use App\User;

class DashboardController extends Controller
{
    public function index()
    {
        $users_count = User::count();
        $branches_count = Branch::count();
        $departments_count = Department::count();
        $documents_count = Document::count();

        $data = [
            'title' => 'Dashboard',
            'total_number_of_users' => $users_count,
            'total_number_of_branches' => $branches_count,
            'total_number_of_documents' => $documents_count,
            'total_number_of_departments' => $departments_count,
        ];

        return view('main/index', $data);
    }
}
