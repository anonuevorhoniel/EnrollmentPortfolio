<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PDFModel extends Model
{
    use HasFactory;
    protected $table = 'receipt';
    protected $fillable = ['user_id',	'filename',	'original_name','mime_type','size',	'path'	];
}
