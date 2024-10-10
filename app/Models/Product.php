<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'Product';

    protected $fillable = [
        'Name',
        'Product_Category',
        'Description',
    ];

    public $timestamps = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function Price(){
        return $this->hasMany(Price::class, 'Product_Id', 'Id');
    }

}
