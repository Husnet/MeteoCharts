<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatteryLevel extends Model
{
    use HasFactory, SoftDeletes;

    public const STATE_CHARGED = 'charged';
    public const STATE_FULL = 'full';
    public const STATE_HIGH = 'high';
    public const STATE_MEDIUM = 'medium';
    public const STATE_LOW = 'low';
    public const STATE_CRITICAL = 'critical';



    protected $fillable = [
        'percent',
        'device_id',
    ];

    public function device() : HasOne {
        return $this->hasOne(Device::class);
    }

    public function getStateAttribute() : string {
        if ($this->percent >= 100) {
            return self::STATE_CHARGED;
        }
        if ($this->percent > 80) {
            return self::STATE_FULL;
        }
        if ($this->percent > 60) {
            return self::STATE_HIGH;
        }
        if ($this->percent > 40) {
            return self::STATE_MEDIUM;
        }
        if ($this->percent > 20) {
            return self::STATE_LOW;
        }
        return self::STATE_CRITICAL;
    }




    public static function convertToPercent(float $voltage) : int {
        // max voltage is 4.2V  (100%)
        // min voltage is 2.5V  (0%)
        $percent = (int) round(($voltage - 2.5) / (4.2 - 2.5) * 100);
        // min - max return value is 0 - 100
        return min(max($percent, 0), 100);

    }

}
