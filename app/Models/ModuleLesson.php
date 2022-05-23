<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleLesson extends Model
{
    protected $table = "module_lesson";
    
    public function create_lesson($module_id,$lesson_id)
    {
        $lesson = new ModuleLesson();
        $lesson->module_id = $module_id;
        $lesson->lesson_id = $lesson_id;
        $lesson->save();
    }

    public function delete_by_module($module_id)
    {
        self::where("module_id",$module_id)->delete();
    }

    public function all_modules($id)
    {
        return self::where('module_id',$id)->count();
    }

    public function module()
    {
        return $this->hasOne(Module::class,"id","module_id");
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class,"id","lesson_id");
    }
}
