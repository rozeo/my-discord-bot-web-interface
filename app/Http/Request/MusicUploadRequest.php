<?php

namespace App\Http\Request;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Rozeo\DiscordData\User;

class MusicUploadRequest
{
    /**
     * @var UploadedFile|null
     */
    private $file;

    /**
     * @var User
     */
    private $user;

    public function __construct(Request $request)
    {
        $this->file = $request->file('file');
        $this->user = $request->session()->get('user');
    }

    public function valid(): bool
    {
        return strpos($this->file->getMimeType(), 'audio/') === 0;
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}