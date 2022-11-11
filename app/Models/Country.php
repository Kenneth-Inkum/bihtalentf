<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $fillable = [
        'country_name',
        'country_code',
    ];

    public function region()
    {
        return $this->hasMany(Region::class);
    }

    public function location()
    {
        return $this->hasMany(Location::class);
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
