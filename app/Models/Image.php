<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'entity_id','entity_type', 'updated_at', 'created_at'];

    private $paths = [
        Lesson::class =>  'lessons/'
    ];

    public function getUrl()
    {
        return url('storage/' . $this->paths[$this->entity_type] . $this->entity_id . '/images/' . $this->filename);
    }
}
