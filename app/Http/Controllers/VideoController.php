<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function upload(Request  $request)
    {
        $attributes =  $request->validate([
            'file' => 'required|file',
            'lesson_id' => 'required|numeric'
        ]);

        $lesson = Lesson::findOrFail($attributes['lesson_id']);
        $file = $attributes['file'];


        $path = 'public/lessons/' . $lesson->id . DIRECTORY_SEPARATOR . '/videos/';
        $chunkPathDirectory = "chunks/lessons/{$lesson->id}";

        $chunkPathDirectoryExists = Storage::exists($chunkPathDirectory);
        if (!$chunkPathDirectoryExists) {
            Storage::makeDirectory($chunkPathDirectory);
        }
        $chunkPath = "{$chunkPathDirectory}/{$file->getClientOriginalName()}";

        File::append(Storage::disk('local')->path($chunkPath), $file->get());
        if ($request->has('is_last') && $request->boolean('is_last')) {
            Storage::deleteDirectory($path);
            $formattedVideoFileName =  str_replace(' ', '-', $file->getClientOriginalName());
            Storage::move(
                "{$chunkPathDirectory}/{$file->getClientOriginalName()}",
                "{$path}{$formattedVideoFileName}"
            );
            Video::where('entity_id', $lesson->id)->where('entity_type', Lesson::class)->delete();

            $video = Video::create([
                'filename' => $formattedVideoFileName,
                'entity_type' => Lesson::class,
                'entity_id' => $lesson->id
            ]);

            return response()->json(['video_url' => $video->getUrl()], 200);
        } else {
            return response()->json('success');
        }
    }
    public function externalUpload(Request  $request)
    {
        $attributes =  $request->validate([
            'external_url' => 'required',
            'lesson_id' => 'required|numeric'
        ]);

        $lesson = Lesson::findOrFail($attributes['lesson_id']);
        $video = Video::create([
            'filename' => 'video',
            'entity_type' => Lesson::class,
            'entity_id' => $lesson->id,
            'external_url' => $attributes['external_url'],
        ]);

        return response()->json(['url' => $video->getUrl()]);
    }
}