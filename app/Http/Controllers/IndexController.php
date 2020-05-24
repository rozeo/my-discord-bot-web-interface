<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Rozeo\DiscordAuthorizer;
use Rozeo\DiscordData\User;

class IndexController
{
    private $auth;

    public function __construct(DiscordAuthorizer $auth)
    {
        $this->auth = $auth;
    }

    public function index(Request $request)
    {
        $user = new User((array)$request->session()->get('auth_data')['user']);

        return view('pages.index');
    }

    public function callback(Request $request)
    {
        if ($this->auth->authorize($request->get('code'))) {
            $user = json_decode(
                $this->auth->request('https://discordapp.com/api/users/@me')
            );

            $request->session()
                ->put('auth_data', [
                    'user' => $user,
                    'tokens' => [
                        'bearer' => $this->auth->getToken(),
                        'refresh' => $this->auth->getRefreshToken(),
                    ],
                ]);

            return redirect()->route('home');
        }

        return response('Invalid request.', 400);
    }
}