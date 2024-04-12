<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    use HasFactory;
    protected $table = 'added_subject';
    protected $fillable = ['subj_name',	'schedule',	'year_lvl',	'points', 'course'];
}
