<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminCourseModel extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $fillable = ['courses'];
}
