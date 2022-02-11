<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Model\SpotifyWeb;

use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class AvailableMarket
{
    /**
     * @psalm-var non-empty-string
     */
    private string $name;

    /**
     * @psalm-param non-empty-string $name
     */
    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function create(string $name): self
    {
        Assert::stringNotEmpty($name);

        return new self($name);
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
