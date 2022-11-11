<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    protected $table = 'industries';

    protected $fillable = [
        'industry_name',
    ];

    public function jobOpening()
    {
        return $this->hasMany(JobOpening::class);
    }

    public function recruit()
    {
        return $this->hasMany(Recruit::class);
    }

    public function company()
    {
        return $this->hasMany(Company::class);
    }

}
