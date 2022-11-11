<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOpening extends Model
{
    use HasFactory;

    protected $table = 'job_openings';

    protected $fillable = [
        'company_id',
        'job_title_id',
        'industry_id',
        'job_type',
        'job_description',
        'duty',
        'location_id',
        'required_skill',
        'activity',
        'challenge',
        'experience',
        'salary',
        'closing_date',
    ];

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
