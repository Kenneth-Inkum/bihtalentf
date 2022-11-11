<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'company_name',
        'company_size',
        'industry_id',
        'location_id',
        'region_id',
        'country_id',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function jobOpening()
    {
        return $this->hasMany(JobOpening::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

}
