<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionModel extends Model
{
    use HasFactory;
    protected $table = 'section';
    protected $fillable = ['user_id', 'section', 'name', 'lastname', 'course', 'year_level'];
}
