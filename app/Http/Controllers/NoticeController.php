<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Notice;

class NoticeController extends ApiController
{
    private $notice;

    public function __construct(Notice $notice)
    {
        $this->notice = $notice;   
    }
    public function list(Request $request, $status = 'All')
    {
        $notices = $this->notice->getNotices($status);
        if($request->wantsJson())
        {
            $notices = $this->notice->getNotices('Publish');
            if(empty($notices))
            {
                return $this->errorResponse('No Notices', 200);
            }
            return $this->successResponse($notices, 'Notice List', 200);
        }
        $noticeCount = $this->notice->getNoticeStatusCount();
        return view('notice.list', ['notices'=> $notices, 'status'=>$status, 'noticeCount'=> $noticeCount]);
    }

    public function create(Request $request)
    {
        return view('notice.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ], [
            'title.required' => 'Required',
            'description.required' => 'Required',
        ]);

              // save user meta
            $notice['title'] = $request->input('title');
            $notice['description'] = $request->input('description');
            $notice['status'] = $request->input('notice_status');

            $newNotice = Notice::create($notice);
            if($newNotice)
            {
                return redirect()->route('notice.list', 'All')->with('success', 'Notice created successfully.');;
            }
    }

    // Notice update
    public function update(Request $request, $id)
    {
        $notice = Notice::find($id);
        if(!empty($notice))
        {
            return view('notice.edit',['notice'=>$notice]);
        }
        else {
            return redirect()->route('notice.list', 'All')->with('error', 'The notice doesnot exist.');
        }
    }

    // Notice Store after update
    public function updateNotice(Request $request)
    {
        $noticeId = $request->input('id');
        $notice['id'] = $noticeId;
        $notice['title'] = $request->input('title');
        $notice['description'] = $request->input('description');
        $notice['status'] = $request->input('notice_status');

       $updateNotice =  $this->notice->updateNoticeItem($notice);
       if($updateNotice)
       {
        return redirect()->route('notice.list', 'All')->with('success', 'Notice updated successfully.');
       }
    }

    // Notice Detail Page
    public function detail(Request $request, $id)
    {
        $notice = Notice::find($id);
        if($request->wantsJson())
        {
            if(empty($notice))
            {
                return $this->errorResponse('Not Found', 404);
            }
            return $this->successResponse($notice, 'Notice Detail', 200);
        }
        return view('notice.detail',['notice'=>$notice]);
    }

    // Delete Notice
    public function delete(Request $request, $id)
    {
        $this->notice->deleteNotice($id);
        return redirect()->route('notice.list', 'All')->with('success', 'Notice deleted successfully.');
    }
    
    // restore Notice
    public function restore(Request $request, $id)
    {
        $this->notice->restoreNotice($id);
        return redirect()->route('notice.list', 'All')->with('success', 'Notice restored successfully.');
    }

    // permanently delete Notice
    public function permanentlyDelete(Request $request, $id)
    {
        $this->notice->permanentlyDelete($id);
        return redirect()->route('notice.list', 'All')->with('success', 'Notice deleted permanently.');
    }
}
