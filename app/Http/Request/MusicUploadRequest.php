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
    private User $user;

    public function __construct(Request $request)
    {
        $this->file = $request->file('file');
        $this->user = new User((array)$request->session()->get('auth_data')['user']);
    }

    public function valid(): bool
    {
        return strpos('audio/', $this->file->getMimeType()) === 0;
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