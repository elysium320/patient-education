<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = "quizzes";

    protected $fillable = ['title', 'lesson_id', 'updated_at', 'created_at'];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quiz_questions');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }


    /*/**---------------------------------------------------------
      * *      get all Quizzes with Lessson Relation
      *---------------------------------------------------------------**/


    public function allQuizzes()
    {
        return self::orderBy("id", "DESC")->with('lession')->get();
    }

    /*/**---------------------------------------------------------
      * *      Lesson Table Relation with Quiz table
      *---------------------------------------------------------------**/


    public function lession()
    {
        return $this->hasOne(Lesson::class, "id", "lesson_id");
    }


    /*/**---------------------------------------------------------
      * *     Delete Quiz By ID
      *---------------------------------------------------------------**/


    public function delete_by_id($id)
    {
        if(self::find($id))
        {
            self::where("id",$id)->delete();
            return true;
        }
        else{
            return false;
        }
    }
}
