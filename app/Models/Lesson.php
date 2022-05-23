<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'instructions',
        'additional_info',
        'category_id'
    ];

    protected $appends = ['cover_image', 'video_url'];

    public function getCoverImageAttribute()
    {
        return $this->getCover();
    }

    public function getVideoUrlAttribute()
    {
        return $this->getFirstVideo();
    }

    public function quizzes()
    {

        return $this->belongsToMany(Quiz::class, 'lesson_quizzes');
    }

    public function videos()
    {

        return $this->hasMany(Video::class, 'entity_id')->where('entity_type', Lesson::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'entity_id')->where('entity_type', Lesson::class);
    }

    public function getCover()
    {
        $image = $this->images;

        if (count($this->images)) {
            return $image[0]->getUrl();
        }

        return '/img/noImage.jpg';
    }

    public function getQuiz()
    {
        $quizzes = $this->quizzes;

        if (count($quizzes)) {
            return $quizzes[0]->id;
        }

        return 0;
    }

    public function getFirstVideo()
    {
        $videos = $this->videos;

        if (count($this->videos)) {
            return $videos[0]->getUrl();
        }

        return '/img/no-video.png';
    }



    public function module()
    {
        return $this->belongsToMany(Module::class, 'module_lesson', 'lesson_id', 'module_id');
    }
}
