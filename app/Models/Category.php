<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['name',"user_id","company_id"];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
