<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    protected $table = 'enroll_table';

    protected $fillable = [
       'user_id', 'name', 'lastname', 'age', 'address', 'religion', 'gender'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
