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
      'customer_identification' => 'required',
      'customer_name' => 'required',
      'customer_email' => 'required',
      'customer_mobile' => 'required'
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['customer_identification','customer_identification_type','customer_name','customer_email','customer_mobile','status','product','total'];



}
