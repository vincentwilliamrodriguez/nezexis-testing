<?php

namespace Modules\ClientManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\ClientManagement\Database\Factories\StatusFactory;

class Status extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'refstat';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'updated_by',
    ];

    // protected static function newFactory(): StatusFactory
    // {
    //     // return StatusFactory::new();
    // }
}
