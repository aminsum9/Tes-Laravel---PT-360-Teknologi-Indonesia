<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'Price';

    protected $fillable = [
        'Product_Id',
        'Unit',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function PriceDetail(){
        return $this->hasMany(PriceDetail::class, 'Product_Id', 'Id');
    }

}