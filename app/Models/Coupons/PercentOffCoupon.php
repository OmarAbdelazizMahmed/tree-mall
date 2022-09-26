<?php

namespace App\Models\Coupons;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PercentOffCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'percent_off',
    ];


    public function coupon()
    {
        return $this->morphOne(Coupon::class, 'couponable');
    }


    public function discount($order)
    {
        return round($order * $this->percent_off / 100);
    }
}
