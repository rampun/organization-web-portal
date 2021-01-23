<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Department;

class DepartmentController extends ApiController
{

    private $department;

    public function __construct(Department $department)
    {
        $this->department = $department;   
    }

    public function list(Request $request, $status = 'All')
    {
        $departments = $this->department->getDepartments($status);
        if($request->wantsJson())
        {
            $departments = $this->department->getDepartments('Publish');
            if(empty($departments))
            {
                return $this->errorResponse('No Departments', 200);
            }
            return $this->successResponse($departments, 'Department List', 200);
        }
        $departmentCount = $this->department->getDepartmentStatusCount();

        return view('department.list', ['departments'=> $departments, 'status'=>$status, 'departmentCount'=> $departmentCount]);
    }


    public function create(Request $request)
    {
        return view('department.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'coordinator' => 'required',
        ], [
            'name.required' => 'Required',
            'coordinator.required' => 'Required',
        ]);

            // save department
            $department['name'] = $request->input('name');
            $department['coordinator'] = $request->input('coordinator');
            $department['meta'] = $request->input('department_meta');
            // $department['status'] = $request->input('status');
            $department['status'] = 'Publish';

            $newdepartment = Department::create($department);
            if($newdepartment)
            {
                return redirect()->route('department.list', 'All')->with('success', 'Department created successfully.');;
            }
    }

    // department Detail Page
    // public function detail(Request $request, $id)
    // {
    //     $departments = Department::find($id);

    //     return view('department.detail',['departments'=>$departments]);
    // }

    // // Department update
    // public function update(Request $request, $id)
    // {
    //     $department = Department::find($id);
    //     if(!empty($department))
    //     {
    //         return view('department.edit',['department'=>$department]);
    //     }
    //     else {
    //         return redirect()->route('department.list', 'All')->with('error', 'The department doesnot exist.');
    //     }
    // }

    // // department Store after update
    // public function updatedepartment(Request $request)
    // {
    //     $departmentId = $request->input('id');
    //     $department['id'] = $departmentId;
    //     $department['name'] = $request->input('file_name');
    //     $department['visibility'] = $request->input('visibility');
    //     $department['status'] = $request->input('status');


    //     // Department Image Handling
    //     if ($request->hasFile('file')) {
    //         if ($request->file('file')->isValid()) {
    //             $department_file_name = strval(str_replace(' ', '',time() . $request->input('start_date').'.'.$request->file->extension()));
    //             $request->file->move(public_path('uploads/department/'), $department_file_name);
    //             $department['file'] = $department_file_name;
    //         }
    //     }
    //     else {
    //         $singleDepartment = $this->department->getDepartmentSingle($departmentId);
    //         $department['file'] = $singleDepartment->file;
    //     }

        
    //    $updatedepartment =  $this->department->updatedepartmentItem($department);
    //    if($updatedepartment)
    //    {
    //         return back()->with('success', 'File updated successfully.');
    //    }
    // }

     // Delete department
     public function delete(Request $request, $id)
     {
        $this->department->deletedepartment($id);
        return redirect()->route('department.list', 'All')->with('success', 'File deleted successfully.');
     }


    // restore Department
    public function restore(Request $request, $id)
    {
        $this->department->restoreDepartment($id);
        return redirect()->route('department.list', 'All')->with('success', 'Department restored successfully.');
    }

    // permanently delete Department
    public function permanentlyDelete(Request $request, $id)
    {
        $this->department->permanentlyDelete($id);
        return redirect()->route('department.list', 'All')->with('success', 'Department deleted permanently.');
    }
}
