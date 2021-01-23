<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Download;
use App\Http\Traits\UserTrait;

class DownloadController extends ApiController
{

    private $download;
    use UserTrait;

    public function __construct(Download $download)
    {
        $this->download = $download;   
    }

    public function list(Request $request, $status = 'All')
    {
        // $downloads = [];
        $downloads = $this->download->getDownloads($status);
        if($request->wantsJson())
        {
            $downloads = $this->download->getDownloads('Publish');
            if(empty($downloads))
            {
                return $this->errorResponse('Not Found', 404);
            }
            return $this->successResponse($downloads, 'Download List', 200);
        }

        $downloadCount = $this->download->getDownloadStatusCount();

        return view('download.list', ['downloads'=> $downloads, 'status'=>$status, 'downloadCount'=> $downloadCount]);
    }


    public function create(Request $request)
    {
        return view('download.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'file_name' => 'required',
            'file' => 'required',
        ], [
            'file_name.required' => 'Required',
            'file.required' => 'Required',
        ]);

            // save download
            $download['name'] = $request->input('file_name');
            $download['visibility'] = $request->input('visibility');
            $download['status'] = $request->input('status');



            // Member image handling
            if ($request->hasFile('file')) {
                if ($request->file('file')->isValid()) {
                    $download_file_file_name = time().'_'. str_replace(' ', '_', $request->input('file_name')) . '.' . $request->file->extension();
                    $request->file->move(public_path('uploads/downloads/'), $download_file_file_name);
                    $download['file'] = '/uploads/downloads/' . $download_file_file_name;
                }
            }

            $newdownload = Download::create($download);
            if($newdownload)
            {
                return redirect()->route('download.list', 'All')->with('success', 'Download File created successfully.');;
            }
    }

    // download Detail Page
    public function detail(Request $request, $id)
    {
        $download = Download::find($id);
        if($request->wantsJson())
        {
            if(empty($download))
            {
                return $this->errorResponse('Not Found', 404);
            }
            return $this->successResponse($download, 'Download Detail', 200);
        }
        
        return view('download.detail',['download'=>$download]);
    }

    // Download update
    public function update(Request $request, $id)
    {
        $download = Download::find($id);
        if(!empty($download))
        {
            return view('download.edit',['download'=>$download]);
        }
        else {
            return redirect()->route('download.list', 'All')->with('error', 'The download doesnot exist.');
        }
    }

    // download Store after update
    public function updatedownload(Request $request)
    {
        $downloadId = $request->input('id');
        $download['id'] = $downloadId;
        $download['name'] = $request->input('file_name');
        $download['visibility'] = $request->input('visibility');
        $download['status'] = $request->input('status');


        // Download Image Handling
        if ($request->hasFile('file')) {
            if ($request->file('file')->isValid()) {
                $download_file_name = strval(str_replace(' ', '',time() . $request->input('start_date').'.'.$request->file->extension()));
                $request->file->move(public_path('uploads/download/'), $download_file_name);
                $download['file'] = '/uploads/downloads/'.$download_file_name;
            }
        }
        else {
            $singleDownload = $this->download->getDownloadSingle($downloadId);
            $download['file'] = $singleDownload->file;
        }

        
       $updatedownload =  $this->download->updatedownloadItem($download);
       if($updatedownload)
       {
            return redirect()->route('download.list', 'All')->with('success', 'Download File updated successfully.');;
       }
    }

     // Delete download
     public function delete(Request $request, $id)
     {
        $this->download->deletedownload($id);
        return redirect()->route('download.list', 'All')->with('success', 'File deleted successfully.');
     }
     
    // restore Download
    public function restore(Request $request, $id)
    {
        $this->download->restoreDownload($id);
        return redirect()->route('download.list','All')->with('success', 'Download restored successfully.');
    }

    // permanently delete Download
    public function permanentlyDelete(Request $request, $id)
    {
        $this->download->permanentlyDelete($id);
        return redirect()->route('download.list','All')->with('success', 'Download deleted permanently.');
    }
}
