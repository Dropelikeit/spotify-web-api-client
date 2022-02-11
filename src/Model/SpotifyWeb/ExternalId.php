<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Model\SpotifyWeb;

use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class ExternalId
{
    /**
     * @psalm-var non-empty-string
     */
    private string $source;

    /**
     * @psalm-var non-empty-string
     */
    private string $identifier;

    /**
     * @psalm-param non-empty-string $source
     * @psalm-param non-empty-string $identifier
     */
    private function __construct(string $source, string $identifier)
    {
        $this->source = $source;
        $this->identifier = $identifier;
    }

    public static function create(string $source, string $identifier): self
    {
        Assert::stringNotEmpty($source);
        Assert::stringNotEmpty($identifier);

        return new self($source, $identifier);
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
