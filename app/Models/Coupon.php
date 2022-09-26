<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
    ];

    public function couponable()
    {
        return $this->morphTo();
    }

    public function getValueAttribute()
    {
        return $this->couponable->value;
    }

    public function getPercentOffAttribute()
    {
        return $this->couponable->percent_off;
    }

    public function getDiscountAttribute()
    {
        if ($this->couponable_type === FixedValueCoupon::class) {
            return $this->value;
        }

        if ($this->couponable_type === PercentOffCoupon::class) {
            return $this->percent_off;
        }

        return 0;
    }

    public static function findCoupon($code)
    {
        return self::where('code', $code)->first();
    }

    public function discount($order)
    {
        return $this->couponable->discount($order);
    }
}
