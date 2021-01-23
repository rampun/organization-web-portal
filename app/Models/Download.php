<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\PostStatusTrait;

class Download extends Model
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
        'file',
        'visibility',
        'status'
    ];

    public function getDownloads($status){
        $downloads = $this->getPostByStatus("Download", $status);
        return $downloads;
    }

    public function getDownloadStatusCount()
    {
        $postStatusCount = $this->getPostStatusCount("Download");
        return $postStatusCount;
    }

    public function getDownloadSingle($id)
    {
        $download = Download::find($id);
        return $download;
    }

    public function updateDownloadItem($download)
    {
        $downloadUpdate = Download::where(
            'id', $download['id']
        )
        ->update([
            'name' => $download['name'],
            'file' => $download['file'],
            'visibility' => $download['visibility'],
            'status' => $download['status'],
            'status' => $download['status']
        ]);


        if($downloadUpdate)
        {
            return true;
        }
        else {
            return false;
        }
    }

    // Soft delete Download
    public function deletedownload($id)
    {
        $download = Download::find($id);
        $download->delete();
    }

    // Restore Download
    public function restoreDownload($id)
    {
        Download::withTrashed()->find($id)->restore();
    }

    // Delete Permanently
    public function permanentlyDelete($id)
    {
        $event = Download::withTrashed()->find($id);
        $event->forceDelete();        
    }
}
