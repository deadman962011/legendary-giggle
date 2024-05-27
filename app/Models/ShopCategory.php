<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model
{
    use HasFactory;

    protected $fillable=['shop_id','category_id'];

    protected $with=['category'];

    /**
     * Get the Category associated with the ShopCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }



}
