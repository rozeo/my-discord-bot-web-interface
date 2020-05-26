<?php


namespace Rozeo;

use DateTime;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Date;
use Rozeo\DiscordData\Tokens;

class DiscordAuthorizer
{
    const URI_PREFIX = 'https://discord.com/api';

    private $id;
    private $secret;
    private $token;
    private $scopes;
    private $callback;

    public function __construct(string $id, string $secret, Tokens $token = null)
    {
        $this->id = $id;
        $this->secret = $secret;
        $this->token = $token;

        $this->callback = '';
        $this->scopes = [];
    }

    public function setCallback(string $callback): self
    {
        $this->callback = $callback;
        return $this;
    }

    public function addScopes(string $scope): self
    {
        $this->scopes[] = trim($scope);
        return $this;
    }

    public function setToken(Tokens $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function getToken(): Tokens
    {
        return $this->token;
    }

    public function check()
    {
        if (!$this->token) {
            return;
        }

        if($this->token->getExpireAt() < (new DateTime)) {
            $this->refresh();
        }
    }

    public function getRedirectUri(): string
    {
        return self::URI_PREFIX . '/oauth2/authorize?' .
            http_build_query([
                'redirect_uri' => $this->callback,
                'client_id' => $this->id,
                'response_type' => 'code',
                'scope' => join(' ', $this->scopes),
            ]);
    }

    public function authorize(string $code)
    {
        $client = new Client;

        $content = $client->request(
            'POST',
            self::URI_PREFIX . '/oauth2/token',
            [
                'form_params' => [
                    'client_id' => $this->id,
                    'client_secret' => $this->secret,
                    'redirect_uri' => $this->callback,
                    'code' => $code,
                    'grant_type' => 'authorization_code',
                    'scope' => join(' ', $this->scopes),
                ],
            ]
        );

        $json = json_decode($content->getBody(), true);

        $this->token = new Tokens($json);
    }

    public function request(string $method, string $endpoint, array $params = []): array
    {
        $this->check();

        $client = new Client;

        $request = $client->request(
            $method,
            self::URI_PREFIX . $endpoint,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token->getAccessToken(),
                ],
            ]
        );

        return json_decode($request->getBody(), true);
    }

    public function refresh()
    {
        if ($this->token->getExpireAt() > new Datetime) {
            return false;
        }

        $client = new Client;

        $content = $client->request(
            'POST',
            self::URI_PREFIX . '/oauth2/token',
            [
                'form_params' => [
                    'client_id' => $this->id,
                    'client_secret' => $this->secret,
                    'redirect_uri' => $this->callback,
                    'refresh_token' => $this->token->getRefreshToken(),
                    'grant_type' => 'refresh_token',
                    'scope' => join(' ', $this->scopes),
                ],
            ]
        );

        $json = json_decode($content->getBody(), true);

        $this->token = new Tokens($json);

        return $this->token;
    }
}