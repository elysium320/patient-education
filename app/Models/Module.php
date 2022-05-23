<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'instructions',
        'additional_info',
        'category_id'
    ];

    protected $appends = ['date', 'profile'];

    public function getProfileAttribute()
    {

        return $this->getProfileImage();
    }

    public function getDateAttribute()
    {

        return optional($this->created_at)->format('d M Y');
    }

    public function create_module($request)
    {

        $module = Module::create($request->only([
            'title',
            'description',
            'instructions',
            'additional_info',
            'category_id'
        ]));


        if ($request->has('file')) {
            $file = $request->file('file');
            $directoryPath = 'public/modules/' . $module->id .'/images/profile/';
            if (!Storage::exists($directoryPath)) {
                Storage::makeDirectory($directoryPath);
            } else {
                Storage::deleteDirectory($directoryPath);

            }

            $filePath = $directoryPath . str_replace(' ', '-', $file->getClientOriginalName());
            Storage::disk('local')->put($filePath, file_get_contents($file));
            $module->profile_image = str_replace(' ', '-', $file->getClientOriginalName());
            $module->save();
        }

        if (!$module) {
            return false;
        }
        if ($request->has('lesson_ids')) {
            $ls_list = explode(",", $request->get('lesson_ids'));
            foreach ($ls_list as $ls) {
                $lesson = new ModuleLesson();
                $lesson->create_lesson($module->id, $ls);
            }
        }

        return true;
    }

    public function update_module($request)
    {

         $mod = self::find($request->get('id'));
        $mod->update($request->only([
            'title',
            'description',
            'instructions',
            'additional_info',
            'category_id'
        ]));

        $mod->save();

        if ($request->has('file')) {
            $file = $request->file('file');
            $directoryPath = 'public/modules/' . $request->get('id') .'/images/profile/';
            if (!Storage::exists($directoryPath)) {
                Storage::makeDirectory($directoryPath);
            } else {
                Storage::deleteDirectory($directoryPath);

            }


            $filePath = $directoryPath . str_replace(' ', '-', $file->getClientOriginalName());
            Storage::disk('local')->put($filePath, file_get_contents($file));
            $mod->profile_image = str_replace(' ', '-', $file->getClientOriginalName());
            $mod->save();
        }


        if ($mod) {
            $lesson = new ModuleLesson();
            $lesson->delete_by_module($mod->id);
            $ls_list = explode(",", $request->get('lesson_ids', []));
            foreach ($ls_list as $ls) {
                $lesson = new ModuleLesson();
                $lesson->create_lesson($mod->id, $ls);
            }
            return true;
        }
        return false;
    }


    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'module_lesson', 'module_id', 'lesson_id');
    }

    public function getFirstVideo()
    {
        return 1;
    }

    public function getProfileImage()
    {

        if ($this->profile_image) {
            return '/storage/modules/' . $this->id . '/images/profile/' . $this->profile_image;
        }

        return '/img/noImage.jpg';

    }


}
