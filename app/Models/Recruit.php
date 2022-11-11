<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table ='recruits';

    protected $fillable = [
        'first_name',
        'last_name',
        'other_name',
        'date_of_birth',
        'gender',
        'phone_number',
        'location_id',
        'country_id',
        'region_id',
        'course_id',
        'industry_id',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}
