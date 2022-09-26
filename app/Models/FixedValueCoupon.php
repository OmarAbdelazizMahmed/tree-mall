<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedValueCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
    ];

    public function coupon()
    {
        return $this->morphOne(Coupon::class, 'couponable');
    }

    public function discount($order)
    {
        return $this->value;
    }


}
