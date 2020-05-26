<?php


namespace App\Http\Controllers;


use App\Http\Request\MusicUploadRequest;
use App\Models\Music;
use App\Service\MusicUploadService;

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
}