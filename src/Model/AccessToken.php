<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Model;

use stdClass;
use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class AccessToken
{
    /**
     * @psalm-var non-empty-string
     */
    private string $token;

    /**
     * @psalm-var non-empty-string
     */
    private string $type;

    /**
     * @psalm-var positive-int
     */
    private int $exiresIn;

    /**
     * @psalm-param non-empty-string $token
     * @psalm-param non-empty-string $type
     * @psalm-param positive-int $exiresIn
     */
    private function __construct(string $token, string $type, int $exiresIn)
    {
        $this->token = $token;
        $this->type = $type;
        $this->exiresIn = $exiresIn;
    }

    public static function create(stdClass $accessInformation): self
    {
        Assert::propertyExists($accessInformation, 'access_token');
        $accessToken = (string) $accessInformation->access_token;
        Assert::stringNotEmpty($accessToken);

        Assert::propertyExists($accessInformation, 'token_type');
        $tokenType = (string) $accessInformation->token_type;
        Assert::stringNotEmpty($tokenType);

        Assert::propertyExists($accessInformation, 'expires_in');
        $expiresIn = (int) $accessInformation->expires_in;
        Assert::positiveInteger($expiresIn);

        return new self($accessToken, $tokenType, $expiresIn);
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @psalm-return positive-int
     */
    public function getExiresIn(): int
    {
        return $this->exiresIn;
    }
}
