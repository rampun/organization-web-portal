<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\PostStatusTrait;

class Committee extends Model
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
        'tenure_start_date',
        'tenure_end_date',
        'president',
        'first_vc_president',
        'second_vc_president',
        'general_secretary',
        'secretary',
        'treasurer',
        'vc_treasurer',
        'members',
        'status'
    ];

    public function getCommittees($status){

        $committee = $this->getPostByStatus("Committee", $status, 'tenure_start_date');
        return $committee;
    }

    public function getCommitteeStatusCount()
    {
        $postStatusCount = $this->getPostStatusCount("Committee");
        
        return $postStatusCount;
    }

    public function updateCommitteeItem($committee)
    {
        $committeeUpdate = Committee::where(
            'id', $committee['id']
        )
        ->update([
            'tenure_start_date' => Carbon::parse($committee['tenure_start_date'])->format('Y-m-d'),
            'tenure_end_date' => Carbon::parse($committee['tenure_end_date'])->format('Y-m-d'),
            'president' => $committee['president'],
            'first_vc_president' => $committee['first_vc_president'],
            'second_vc_president' => $committee['second_vc_president'],
            'general_secretary' => $committee['general_secretary'],
            'secretary' => $committee['secretary'],
            'treasurer' => $committee['treasurer'],
            'vc_treasurer' => $committee['vc_treasurer'],
            'members' => json_encode($committee['members']),
            'status' => $committee['status']
        ]);


        if($committeeUpdate)
        {
            return true;
        }
        else {
            return false;
        }
    }

    // Soft Delete Committee
    public function deleteCommittee($id)
    {
        $committee = Committee::find($id);
        $committee->delete();
    }


    // Restore Committee
    public function restoreCommittee($id)
    {
        Committee::withTrashed()->find($id)->restore();
    }

    // Delete Permanently
    public function permanentlyDelete($id)
    {
        $event = Committee::withTrashed()->find($id);
        $event->forceDelete();        
    }

}
