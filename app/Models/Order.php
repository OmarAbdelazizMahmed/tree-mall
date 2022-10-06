<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Dyrynda\Database\Support\GeneratesUuid;


class Order extends Model
{
    use HasFactory, GeneratesUuid;

    protected $fillable = [
        'uuid',
        'user_id',
        'confirmation_number',
        'billing_email',
        'billing_name',
        'billing_name_on_card',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip_code',
        'billing_discount',
        'billing_discount_code',
        'billing_subtotal',
        'billing_tax',
        'billing_total',
        'payment_gateway',
        'shipped',
        'status',
    ];

    protected $casts = [
        'shipped' => 'boolean',
        'created_at' => 'datetime: F j, Y',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }


}
