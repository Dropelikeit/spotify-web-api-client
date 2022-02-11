<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Model\SpotifyWeb;

use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class ExternalUrl
{
    /**
     * @psalm-var non-empty-string
     */
    private string $source;

    /**
     * @psalm-var non-empty-string
     */
    private string $url;

    /**
     * @psalm-param non-empty-string $source
     * @psalm-param non-empty-string $url
     */
    private function __construct(string $source, string $url)
    {
        $this->source = $source;
        $this->url = $url;
    }

    public static function create(string $name, string $url): self
    {
        Assert::stringNotEmpty($name);
        Assert::stringNotEmpty($url);

        return new self($name, $url);
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
    public function getUrl(): string
    {
        return $this->url;
    }
}
