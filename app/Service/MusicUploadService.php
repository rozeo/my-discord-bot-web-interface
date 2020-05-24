<?php


namespace App\Service;


use App\Http\Request\MusicUploadRequest;
use App\Models\Music;
use Illuminate\Http\Response;

class MusicUploadService
{
    public function execute(MusicUploadRequest $request): Response
    {
        $file = $request->getFile();

        $sha1 = sha1_file($file->path());

        $dup = Music::where('sha1', $sha1)
            ->get();

        if (count($dup) > 0) {
            return new Response(
                json_encode(['message' => 'Duplicate file already uploaded.']),
                400
            );
        }

        $music = new Music;

        $music->uid = $request->getUser()->getId();
        $music->sha1 = $sha1;
        $music->size = $file->getSize();
        $music->name = $request->getFile()->getClientOriginalName();
        $music->extension = $request->getFile()->getClientOriginalExtension();
        $music->song_name = '';
        $music->artist = '';
        $music->album = '';

        $music->save();

        $file->move(
            storage_path('upload'),
            $sha1
        );

        return new Response([
            'message' => 'upload success.'
        ]);
    }
}