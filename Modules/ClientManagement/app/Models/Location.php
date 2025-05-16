<?php

namespace Modules\ClientManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\ClientManagement\Database\Factories\LocationFactory;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'complocn';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'country',
        'region',
        'province',
        'city',
        'barangay',
        'street_add',
        'zipcode',
        'updated_by',
    ];

    protected static function newFactory(): LocationFactory
    {
        return LocationFactory::new();
    }

    public function locatable() {
        return $this->morphTo();
    }
}
