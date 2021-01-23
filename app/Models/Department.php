<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\PostStatusTrait;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;
    use PostStatusTrait;
    
     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'coordinator',
        'meta',
        'status',
    ];

    public function getDepartments($status){

        $department = $this->getPostByStatus("Department", $status);
        return $department;
    }

    public function getDepartmentStatusCount()
    {
        $postStatusCount = $this->getPostStatusCount('Department');
        return $postStatusCount;
    }

    public function updateDepartmentItem($department)
    {
        $departmentUpdate = Department::where(
            'id', $department['id']
        )
        ->update([
            'name' => $department['name'],
            'coordinator' => $department['coordinator'],
            'meta' => json_encode($department['meta']),
            'status' => $department['status']
        ]);


        if($departmentUpdate)
        {
            return true;
        }
        else {
            return false;
        }
    }

    // Soft delete department
    public function deleteDepartment($id)
    {
        $department = Department::find($id);
        $department->delete();
    }
    // Restore Department
    public function restoreDepartment($id)
    {
        Department::withTrashed()->find($id)->restore();
    }

    // Delete Permanently
    public function permanentlyDelete($id)
    {
        $event = Department::withTrashed()->find($id);
        $event->forceDelete();        
    }
}
