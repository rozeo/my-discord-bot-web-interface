<?php


namespace App\Http\Controllers;


use App\FileStreamedResponse;
use App\Models\Music;
use Illuminate\Http\Request;

class FileController
{
    public function index(Request $request)
    {
        $file = storage_path('upload/' . $request->name);

        if (!file_exists($file)) {
            abort(404, 'not found.');
        }

        $music = Music::where('sha1', $request->name)
            ->first();

        if (!$music) {
            abort(404, 'not found.');
        }

        return new FileStreamedResponse($file, 8192, 200, [
            'Content-Type' => $music->mime_type,
            'Content-Disposition' => 'attachment; filename="' . $music->name . '"',
        ]);
    }
}