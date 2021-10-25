<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;

class HostController extends Controller
{
    public function listProject()
    {
        return view('host.list_project');
    }

    public function create()
    {
        return view('host.create_project');
    }

    public function store(ProjectRequest $request)
    {
        return $request->all();
    }
}