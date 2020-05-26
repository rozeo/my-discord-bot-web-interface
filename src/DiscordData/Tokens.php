<?php


namespace Rozeo\DiscordData;

use DateTimeImmutable;

class Tokens
{
    /**
     * @var string
     */
    private $accessToken;
    /**
     * @var string
     */
    private $refreshToken;
    /**
     * @var DateTimeImmutable
     */
    private $expireAt;
    /**
     * @var string
     */
    private $scope;
    /**
     * @var string
     */
    private $tokenType;

    public function __construct(array $data)
    {
        $this->accessToken = $data['access_token'];
        $this->refreshToken = $data['refresh_token'];
        $this->expireAt = (new DateTimeImmutable)
            ->setTimestamp(time() + intval($data['expires_in']));
        $this->scope = $data['scope'];
        $this->tokenType = $data['token_type'];
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getExpireAt(): DateTimeImmutable
    {
        return $this->expireAt;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }


}