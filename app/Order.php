<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $address
 * @property string $fullname
 * @property string $additional_information
 * @property string $total_sum
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Order extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'address', 'fullname', 'additional_information', 'total_sum', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function cart_items(){
        return $this->hasMany('App\CartItem');
    }

    /**
     * @return array
     */
    public function getProducts() {
        $cart_items = $this->cart_items;
        $products = [];

        foreach ($cart_items as $item) {
            $products[] = $item->product;
        }

        return $products;
    }
}
