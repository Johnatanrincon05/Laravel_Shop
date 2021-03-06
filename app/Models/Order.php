<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * @property $id
 * @property $customer_name
 * @property $customer_email
 * @property $customer_mobile
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Order extends Model
{
    
    static $rules = [
      'customer_identification' => 'required|max:20|min:5',
      'customer_name' => 'required|max:50',
      'customer_email' => 'required|email|max:255',
      'customer_mobile' => 'required|max:10|min:10'
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['order_reference','customer_identification','customer_identification_type','customer_name','customer_email','customer_mobile','status','product','total'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
}
