<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companygalary extends Model
{
    use HasFactory;
    protected $table = 'companygalarys';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'title','description','image_url', 'image_exact_url', 'created_at', 'updated_at'
    ];
     
}
