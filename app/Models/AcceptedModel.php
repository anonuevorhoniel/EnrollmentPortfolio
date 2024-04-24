<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcceptedModel extends Model
{
    use HasFactory;
    protected $table = 'accepted';
    protected $fillable = ['student_id', 'name', 'lastname', 'course', 'year_level'];
}
