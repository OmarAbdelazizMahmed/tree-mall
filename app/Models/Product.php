<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'slug',
        'details',
        'code',
        'description',
        'price',
        'main_image',
        'alt_images',
        'featured',
        'active',
    ];

    protected $casts = [
        'alt_images' => 'array',
        'featured' => 'boolean',
        'active' => 'boolean',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array2 = [
            'categories' => $this->categories->pluck('name')->toArray(),
        ];

        return array_merge($array, $array2);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }


}
