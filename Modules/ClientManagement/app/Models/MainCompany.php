<?php

namespace Modules\ClientManagement\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\ClientManagement\Database\Factories\MainCompanyFactory;


class MainCompany extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'maincomp';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'client_name',
        'status',
        'email',
        'mobile',
        'client_type',
        'updated_by',
    ];

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $currentYear = now()->year;

            $lastClient = self::withTrashed()
                ->whereYear('created_at', $currentYear)
                ->latest('clientid')
                ->first();

            $lastNumber = $lastClient ? (int)substr($lastClient->clientid, -6) : 0;
            $model->clientid = sprintf("CVI-%s-%06d", $currentYear, $lastNumber + 1);
        });
    }

    protected static function newFactory(): MainCompanyFactory
    {
        return MainCompanyFactory::new();
    }

    function branches() {
        return $this->hasMany(Branch::class, 'client_id');
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
