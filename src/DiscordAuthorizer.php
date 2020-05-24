<?php


namespace Rozeo;

use GuzzleHttp\Client;

class DiscordAuthorizer
{
    private string $id;
    private string $secret;
    private string $token;
    private array $scopes;
    private string $callback;
    private string $ref_token;

    public function __construct(string $id, string $secret, string $token = '', string $ref_token = '')
    {
        $this->id = $id;
        $this->secret = $secret;
        $this->token = $token;
        $this->ref_token = $ref_token;

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
        $this->scopes[] = $scope;
        return $this;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function setRefreshToken(string $ref_token): self
    {
        $this->ref_token = $ref_token;
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getRefreshToken(): string
    {
        return $this->ref_token;
    }

    public function getRedirectUri(): string
    {
        return 'https://discord.com/api/oauth2/authorize?' .
            http_build_query([
                'redirect_uri' => $this->callback,
                'client_id' => $this->id,
                'response_type' => 'code',
                'scope' => join('%20', $this->scopes),
            ]);
    }

    public function authorize(string $code): bool
    {
        $client = new Client;

        try {
            $content = $client->request(
                'POST',
                'https://discord.com/api/oauth2/token',
                [
                    'form_params' => [
                        'client_id' => $this->id,
                        'client_secret' => $this->secret,
                        'redirect_uri' => $this->callback,
                        'code' => $code,
                        'grant_type' => 'authorization_code',
                        'scope' => join('%20', $this->scopes),
                    ],
                ]
            );
        } catch (\Exception $e) {
            return false;
        }

        $json = json_decode((string)$content->getBody(), true);

        $this->setToken($json['access_token'])
            ->setRefreshToken($json['refresh_token']);

        return true;
    }

    public function request(string $endpoint)
    {
        $client = new Client;

        try {
            $request = $client->request(
                'GET',
                $endpoint,
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->getToken(),
                    ],
                ]
            );

            return (string)$request->getBody();
        } catch (\Exception $e) {
            return false;
        }
    }
}