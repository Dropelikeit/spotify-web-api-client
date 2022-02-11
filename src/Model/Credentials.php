<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Model;

use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class Credentials
{
    /**
     * @psalm-var non-empty-string
     */
    private string $clientId;

    /**
     * @psalm-var non-empty-string
     */
    private string $clientSecret;

    /**
     * @psalm-param non-empty-string $clientId
     * @psalm-param non-empty-string $clientSecret
     */
    private function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @param array<string, mixed> $credentials
     */
    public static function create(array $credentials): self
    {
        Assert::keyExists($credentials, 'clientId');
        $clientId = $credentials['clientId'];
        Assert::stringNotEmpty($clientId);

        Assert::keyExists($credentials, 'clientSecret');
        $clientSecret = $credentials['clientSecret'];
        Assert::stringNotEmpty($clientSecret);

        return new self($clientId, $clientSecret);
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }
}
