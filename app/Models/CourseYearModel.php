<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseYearModel extends Model
{
    use HasFactory;
    protected $table = 'courseyear';
    protected $fillable = ['user_id','course', 'year_level'];
}
