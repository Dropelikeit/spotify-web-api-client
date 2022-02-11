<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Model\SpotifyWeb;

use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class Image
{
    /**
     * @psalm-var positive-int
     */
    private int $height;

    /**
     * @psalm-var positive-int
     */
    private int $width;

    /**
     * @psalm-var non-empty-string
     */
    private string $url;

    /**
     * @psalm-param positive-int $height
     * @psalm-param positive-int $width
     * @psalm-param non-empty-string $url
     */
    private function __construct(int $height, int $width, string $url)
    {
        $this->height = $height;
        $this->width = $width;
        $this->url = $url;
    }

    /**
     * @param array<string, mixed> $image
     */
    public static function create(array $image): self
    {
        Assert::keyExists($image, 'height');
        $height = $image['height'];
        Assert::positiveInteger($height);

        Assert::keyExists($image, 'width');
        $width = $image['width'];
        Assert::positiveInteger($width);

        Assert::keyExists($image, 'url');
        $url = $image['url'];
        Assert::stringNotEmpty($url);

        return new self($height, $width, $url);
    }

    /**
     * @psalm-return positive-int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @psalm-return positive-int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
