<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectStudentModel extends Model
{
    use HasFactory;
    protected $table = "subjects";
    protected $fillable = ['user_id', 'course_id',	'year_level',	'subject_name',	'schedule',	'points', 'course', 'professor'];
}
