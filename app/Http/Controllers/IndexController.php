<?php


namespace App\Http\Controllers;


use GuzzleHttp\Exception\GuzzleException;
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

    public function index()
    {
        return view('pages.index', [
            'redirectUri' => $this->auth->getRedirectUri()
        ]);
    }

    public function home(Request $request)
    {
        return view('pages.home');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('token');
        $request->session()->forget('user');

        return redirect()->route('index');
    }

    public function callback(Request $request)
    {
        if ($request->get('code') === null) {
            abort(400, 'bad request.');
        }

        try {
            $this->auth->authorize($request->get('code'));
        } catch(GuzzleException $e) {
            return response('Invalid request.', 400);
        }

        // 520943516981919744 === ALLLIVE discord guild id
        if (!$this->checkGuilds('520943516981919744')) {
            return response("You not joined ALLLIVE's Discord guild.", 403);
        }

        $user = new User(
            $this->auth->request('GET', '/users/@me')
        );

        $request->session()->put('user', $user);
        $request->session()->put('token', $this->auth->getToken());

        return redirect()->route('home');
    }

    private function checkGuilds(string $id): bool
    {
        foreach($this->auth->request('GET', '/users/@me/guilds') as $guild) {
            if ($guild['id'] === $id) {
                return true;
            }
        }
        return false;
    }
}