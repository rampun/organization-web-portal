<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Committee;
use Carbon\Carbon;
use App\Http\Traits\UserTrait;

class CommitteeController extends ApiController
{

    private $committee;
    use UserTrait;

    public function __construct(Committee $committee)
    {
        $this->committee = $committee;   
    }

    public function list(Request $request, $status = 'All')
    {
        // $committees = [];
        $committees = $this->committee->getCommittees($status);

        if($request->wantsJson())
        {
            $committees = $this->committee->getCommittees('Publish');
            if(empty($committees))
            {
                return $this->errorResponse('No Committees', 200);
            }
            return $this->successResponse($committees, 'Committee List', 200);
        }

        $committeeCount = $this->committee->getCommitteeStatusCount();

        return view('committee.list')->with(['committees'=> $committees, 'status'=>$status, 'committeeCount'=>$committeeCount]);
    }


    public function create(Request $request)
    {
        return view('committee.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tenure_start_date' => 'required',
            'president' => 'required',
            'first_vc_president' => 'required',
            'general_secretary' => 'required',
            'treasurer' => 'required',
            'members' => 'required',
        ], [
            'tenure_start_date.required' => 'Required',
            'president.required' => 'Required',
            'first_vc_president.required' => 'Required',
            'general_secretary.required' => 'Required',
            'treasurer.required' => 'Required',
            'members.required' => 'Required',
        ]);

            // save committee
            $committee['tenure_start_date'] = Carbon::parse($request->input('tenure_start_date'))->format('Y-m-d');
            $committee['tenure_end_date'] = Carbon::parse($request->input('tenure_end_date'))->format('Y-m-d');
            $committee['president'] = $request->input('president');
            $committee['first_vc_president'] = $request->input('first_vc_president');
            $committee['second_vc_president'] = $request->input('second_vc_president');
            $committee['general_secretary'] = $request->input('general_secretary');
            $committee['secretary'] = $request->input('secretary');
            $committee['treasurer'] = $request->input('treasurer');
            $committee['vc_treasurer'] = $request->input('vc_treasurer');
            $committee['members'] = json_encode($request->input('members'));
            $committee['status'] = $request->input('committee_status');

            $newCommittee = Committee::create($committee);
            if($newCommittee)
            {
                return redirect()->route('committee.list', 'All')->with('success', 'Committe created successfully.');;
            }
    }

    // Committee Detail Page
    public function detail(Request $request, $id)
    {
        $committee = Committee::find($id);
        if($request->wantsJson())
        {
            if(empty($committee))
            {
                return $this->errorResponse('Not Found', 404);
            }
            return $this->successResponse($committee, 'Committee Detail', 200);
        }
        return view('committee.detail',['committee'=>$committee]);
    }


    // Event update
    public function update(Request $request, $id)
    {
        $committee = Committee::find($id);
        if(!empty($committee))
        {
            return view('committee.edit',['committee'=>$committee]);
        }
        else {
            return redirect()->route('committee.list', 'All')->with('error', 'The committee doesnot exist.');
        }
    }

    // Committee Store after update
    public function updateCommittee(Request $request)
    {
        $committeeId = $request->input('id');
        $committee['id'] = $committeeId;
        $committee['tenure_start_date'] = Carbon::parse($request->input('tenure_start_date'))->format('Y-m-d');
        $committee['tenure_end_date'] = Carbon::parse($request->input('tenure_end_date'))->format('Y-m-d');
        $committee['president'] = $request->input('president');
        $committee['first_vc_president'] = $request->input('first_vc_president');
        $committee['second_vc_president'] = $request->input('second_vc_president');
        $committee['general_secretary'] = $request->input('general_secretary');
        $committee['secretary'] = $request->input('secretary');
        $committee['treasurer'] = $request->input('treasurer');
        $committee['vc_treasurer'] = $request->input('vc_treasurer');
        $committee['members'] = $request->input('members');
        $committee['status'] = $request->input('committee_status');

       $updateCommittee =  $this->committee->updateCommitteeItem($committee);
       if($updateCommittee)
       {
            // return back()->with('success', 'Committee updated successfully.');
            return redirect()->route('committee.list', 'All')->with('success', 'Committee updated successfully.');
       }
    }

     // Delete Committee
     public function delete(Request $request, $id)
     {
        $this->committee->deleteCommittee($id);
        return redirect()->route('committee.list', 'All')->with('success', 'Committee deleted successfully.');
     }
     
    // restore Committee
    public function restore(Request $request, $id)
    {
        $this->committee->restoreCommittee($id);
        return redirect()->route('committee.list','All')->with('success', 'Committee restored successfully.');
    }

    // permanently delete Committee
    public function permanentlyDelete(Request $request, $id)
    {
        $this->committee->permanentlyDelete($id);
        return redirect()->route('committee.list','All')->with('success', 'Committee deleted permanently.');
    }
}
