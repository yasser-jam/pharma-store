<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medcine extends Model
{
    use HasFactory;
    protected $fillable = [
        "sciName","useName",
        "category_id","companyName","qtn","expiredDate",
        "price","description","user_id"
    ];
    public function category(){

        return $this->belongsTo(Category::class);

    }

}
