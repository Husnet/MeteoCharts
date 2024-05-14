<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    public const IMAGE_PATH = 'storage/devices/';
    public const DEFAULT_IMAGE = self::IMAGE_PATH . 'placeholder.png';

    protected $fillable = [
        'name',
        'mac_address',
        'token',
        'is_registrating',
        'has_battery',
        'owner_id',
        'last_sync',
    ];

    protected $casts = [
        'is_registrating' => 'boolean',
        'has_battery' => 'boolean',
        'last_sync' => 'datetime',
    ];

    public function getImageFailsafeAttribute() {
        // if device image is not set, return default image
        return $this->image ?? asset(self::DEFAULT_IMAGE);
    }
    public function getLastTemperatureAttribute(): Temperature | null {
        return $this->temperatures()->latest()->first();
    }
    public function getLastHumidityAttribute(): Humidity | null {
        return $this->humidities()->latest()->first();
    }
    public function getLastPressureAttribute(): Pressure | null {
        return $this->pressures()->latest()->first();
    }
    public function getLastBatteryLevelAttribute(): BatteryLevel | null
    {
        return $this->batteryLevels()->latest()->first();
    }


    public function owner(): HasOne {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }
    public function temperatures(): HasMany {
        return $this->hasMany(Temperature::class);
    }
    public function humidities(): HasMany {
        return $this->hasMany(Humidity::class);
    }
    public function pressures(): HasMany {
        return $this->hasMany(Pressure::class);
    }
    public function batteryLevels(): HasMany {
        return $this->hasMany(BatteryLevel::class);
    }

    public function logs(): HasMany {
        return $this->hasMany(Log::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('user', function (Builder $builder) {
            $builder->where('owner_id', auth()->id());
        });
    }

}
