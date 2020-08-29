<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CartItem
 *
 * @property integer $id
 * @property string $code
 * @property integer $user_id
 * @property integer $product_id
 * @property integer $quantity
 */
class CartItem extends Model {

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [ 'quantity' => 'integer' ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'code', 'user_id', 'product_id', 'quantity' ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function product()
    {
        return $this->belongsTo('App\Product');
    }

}