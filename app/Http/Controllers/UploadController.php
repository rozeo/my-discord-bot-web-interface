<?php


namespace App\Http\Controllers;


use App\Http\Request\MusicUploadRequest;
use App\Service\MusicUploadService;

class UploadController
{
    public function index()
    {
        return view('pages.upload');
    }

    public function upload(MusicUploadRequest $request, MusicUploadService $service)
    {
        if (!$request->valid()) {
            abort(400, 'invalid file uploaded.');
        }

        return $service->execute($request);
    }
}