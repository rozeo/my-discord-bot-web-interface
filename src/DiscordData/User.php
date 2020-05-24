<?php


namespace Rozeo\DiscordData;


class User implements \JsonSerializable
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getCombinedName(): string
    {
        return join('#', [
            $this->getUsername(),
            $this->getDiscriminator()
        ]);
    }

    public function getId(): string
    {
        return $this->data['id'];
    }

    public function getUsername(): string
    {
        return $this->data['username'];
    }

    public function getAvatar(): string
    {
        return $this->data['avatar'];
    }

    public function getDiscriminator(): string
    {
        return $this->data['discriminator'];
    }

    public function getPublicFlags(): int
    {
        return $this->data['public_flags'];
    }

    public function getFlags(): int
    {
        return $this->data['flags'];
    }

    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }

    public function jsonSerialize()
    {
        return $this->data;
    }
}