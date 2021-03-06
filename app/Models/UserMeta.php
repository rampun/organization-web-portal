<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\PostStatusTrait;

class UserMeta extends Model
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
        'user_id',
        'membership_type',
        'membership_no',
        'issue_date',
        'expiry_date',
        'family_name',
        'address_np',
        'province_np',
        'district_np',
        'address_hk',
        'district_hk',
        'region_hk',
        'document_type',
        'document_no',
        'mobile_no',
        'member_photo',
        'telephone_no',
        'spouse_name',
        'spouse_job',
        'spouse_photo',
        'job'
    ];
}
