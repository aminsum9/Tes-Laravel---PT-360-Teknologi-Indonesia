<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceDetail extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'Id';

    protected $table = 'PriceDetail';

    protected $fillable = [
        'Price_Id',
        'Tier',
        'Price',
    ];

    public $timestamps = false;
    
}
