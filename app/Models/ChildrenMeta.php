<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildrenMeta extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        'full_name',
        'dob',
        'gender',
        'photo',
        'education_level',
    ];


    
    // many to one relation
    public function parentusers()
    {
        return $this->belongsTo('App\Models\User');
    }

    // include any function here
    // public static function getChildrenSearch($type, $location)
    // {
    //     $childrens = ChildrenMeta::where('location', 'LIKE', "%$location%")
    //             ->where('category_id', $type)->get();
    //     return $childrens;
    // }
}
