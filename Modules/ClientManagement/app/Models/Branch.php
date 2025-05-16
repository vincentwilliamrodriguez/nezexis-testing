<?php

namespace Modules\ClientManagement\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\ClientManagement\Database\Factories\BranchFactory;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'compbrch';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'branch_name',
        'client_id',
        'status',
        'email',
        'mobile',
        'updated_by',
    ];

    protected static function newFactory(): BranchFactory
    {
        return BranchFactory::new();
    }

    function mainCompany() {
        return $this->belongsTo(MainCompany::class, 'client_id');
    }

    function location() {
        return $this->morphOne(Location::class, 'locatable');
    }

    function statusRef() {
        return $this->belongsTo(Status::class, 'status');
    }

    protected function statusName(): Attribute {
        return Attribute::make(
            get: fn () => $this->statusRef?->name,
        );
    }
}
