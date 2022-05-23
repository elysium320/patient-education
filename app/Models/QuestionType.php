<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'type' ,'updated_at', 'created_at'];

    public const TYPES = ['SINGLE' => 1, 'MULTIPLE' => 2, 'BOOLEAN' => 3];

}
