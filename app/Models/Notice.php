<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\PostStatusTrait;

class Notice extends Model
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
        'title',
        'description',
        'status'
    ];

    public function getNotices($status){

        $notices = $this->getPostByStatus("Notice", $status);
        return $notices;
    }

    public function getNoticeStatusCount()
    {
        $postStatusCount = $this->getPostStatusCount('Notice');
        return $postStatusCount;
    }

    public function getNoticeSingle($id)
    {
        $notice = Notice::find($id);
        return $notice;
    }

    public function updateNoticeItem($notice)
    {
        $noticeUpdate = Notice::where(
            'id', $notice['id']
        )
        ->update([
            'title' => $notice['title'],
            'description' => $notice['description'],
            'status' => $notice['status']
        ]);

        if($noticeUpdate)
        {
            return true;
        }
        else {
            return false;
        }
    }

    // soft delete notice
    public function deleteNotice($id)
    {
        $user = Notice::find($id);
        $user->delete();
    }

    // Restore Notice
    public function restoreNotice($id)
    {
        Notice::withTrashed()->find($id)->restore();
    }

    // Delete Permanently
    public function permanentlyDelete($id)
    {
        $notice = Notice::withTrashed()->find($id);
        $notice->forceDelete();        
    }

}