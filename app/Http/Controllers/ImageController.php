<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
       $attributes =  $request->validate([
            'file' => 'required|file',
            'lesson_id' => 'required|numeric'
        ]);

        $lesson = Lesson::findOrFail($attributes['lesson_id']);

        $directoryPath = 'public/lessons/' . $lesson->id . '/images/' . DIRECTORY_SEPARATOR;
//
        if (!Storage::exists($directoryPath)) {
            Storage::makeDirectory($directoryPath);
        } else {
            Storage::deleteDirectory($directoryPath);

        }

        $filePath = $directoryPath . str_replace(' ', '-', $attributes['file']->getClientOriginalName());
        Storage::disk('local')->put($filePath, file_get_contents($attributes['file']));
        Image::where('entity_id', $lesson->id)->where('entity_type', Lesson::class)->delete();

        $image = Image::create([
            'filename' => str_replace(' ', '-', $attributes['file']->getClientOriginalName()),
            'entity_type' => Lesson::class,
            'entity_id' => $lesson->id
        ]);

        return response()->json(['image_url' => $image->getUrl()], 200);
    }
}
