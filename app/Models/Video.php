<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['filename', 'entity_id', 'entity_type', 'external_url', 'updated_at', 'created_at'];

    use HasFactory;

    protected $appends = ['video_url'];

    public function getVideoUrlAttribute()
    {
        return $this->getUrl();
    }

    private $paths = [
        Lesson::class =>  'lessons/'
    ];

    public function getUrl()
    {
        if ($this->external_url) {
            return $this->external_url;
        }
        return url('storage/' . $this->paths[$this->entity_type] . $this->entity_id . '/videos/' . $this->filename);
    }


}
