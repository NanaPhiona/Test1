<?php

namespace App\Models;

use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'location',
        'description',
        'minimum_academic_qualification',
        'required_experience',
        'photo',
        'how_to_apply',
        'hiring_firm',
        'deadline',
    ];

    protected static function boot()
    {
        parent::boot();

        // Define the updating event listener
        static::updating(function ($job) {
            $auth_user = Admin::user();
            if ($job->user_id !== $auth_user->id) {
                throw new \Exception("You are not authorized to update this job.");
            }
        });
    }
    //
    // public static function boot()
    // {
    //     parent::boot();
    //     self::deleting(function ($m) {
    //     });
    //     self::created(function ($m) {
    //     });
    //     self::creating(function ($m) {

    //         $m->district_id = 1;

    //         if ($m->subcounty_id != null) {
    //             $sub = Location::find($m->subcounty_id);
    //             if ($sub != null) {
    //                 $m->district_id = $sub->parent;
    //             }
    //         }
    //         return $m;
    //     });
    //     self::updating(function ($m) {

    //         $m->district_id = 1;
    //         if ($m->subcounty_id != null) {
    //             $sub = Location::find($m->subcounty_id);
    //             if ($sub != null) {
    //                 $m->district_id = $sub->parent;
    //             }
    //         }

    //         return $m;
    //     });
    // }

    // public function getSubcountyTextAttribute()
    // {
    //     $d = Location::find($this->subcounty_id);
    //     if ($d == null) {
    //         return 'Not group.';
    //     }
    //     return $d->name_text;
    // }
    // protected $appends = ['subcounty_text'];
}
