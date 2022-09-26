<?php

namespace Database\Seeders;

use App\Models\Coupons\Coupon;
use App\Models\Coupons\FixedValueCoupon;
use App\Models\Coupons\PercentOffCoupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $percentOffCoupon = PercentOffCoupon::create([
            'percent_off' => 10,
        ]);

        $fixedValueCoupon = FixedValueCoupon::create([
            'value' => 20,
        ]);

        Coupon::create([
            'code' => '1OFF',
            'couponable_id' => $percentOffCoupon->id,
            'couponable_type' => PercentOffCoupon::class,
        ]);

        Coupon::create([
            'code' => '2OFF',
            'couponable_id' => $percentOffCoupon->id,
            'couponable_type' => PercentOffCoupon::class,
        ]);
    }
}
