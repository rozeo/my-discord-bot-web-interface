<?php


namespace App\Http\Controllers;


use App\Http\Request\MusicUploadRequest;
use App\Models\Music;
use App\Service\MusicUploadService;
use Illuminate\Http\Request;

class MusicController
{
    public function index()
    {
        return view('pages.upload');
    }

    public function list()
    {
        return view('pages.list', [
            'list' => Music::get(),
        ]);
    }

    public function upload(MusicUploadRequest $request, MusicUploadService $service)
    {
        if (!$request->valid()) {
            abort(400, 'invalid file uploaded. [MIME:' .
                $request->getFile()->getMimeType() .
                ']'
            );
        }

        return $service->execute($request);
    }

    public function detail(Request $request)
    {
        $music = Music::where('sha1', $request->name)
            ->get();

        if (count($music) === 0) {
            abort(404, 'not found.');
        }

        return view('pages.music_detail', ['music' => $music->first()]);
    }
}