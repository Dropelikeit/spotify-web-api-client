<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyWebApiClient\Model\SpotifyQrClient;

use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class QrCodePreference
{
    public const BAR_COLOR_WHITE = 'white';
    public const BAR_COLOR_BLACK = 'black';

    private const ALLOWED_BAR_COLORS = [
        self::BAR_COLOR_WHITE,
        self::BAR_COLOR_BLACK,
    ];

    public const FORMAT_JPEG = 'jpeg';
    public const FORMAT_PNG = 'png';
    public const FORMAT_SVG = 'svg';

    private const ALLOWED_FORMAT = [
        self::FORMAT_JPEG,
        self::FORMAT_PNG,
        self::FORMAT_SVG,
    ];

    /**
     * @psalm-var non-empty-string
     */
    private string $backgroundColor;

    /**
     * @psalm-var self::BAR_COLOR_*
     */
    private string $barColor;

    /**
     * @psalm-var positive-int
     */
    private int $size;

    /**
     * @psalm-var self::FORMAT_*
     */
    private string $format;

    /**
     * @example spotify:track:4xkOaSrkexMciUUogZKVTS
     * @psalm-var non-empty-string
     */
    private string $spotifyUri;

    /**
     * @psalm-param non-empty-string $backgroundColor
     * @psalm-param self::BAR_COLOR_* $barColor
     * @psalm-param positive-int $size
     * @psalm-param self::FORMAT_* $format
     * @psalm-param non-empty-string $spotifyUri
     */
    private function __construct(
        string $backgroundColor,
        string $barColor,
        int $size,
        string $format,
        string $spotifyUri
    ) {
        $this->backgroundColor = $backgroundColor;
        $this->barColor = $barColor;
        $this->size = $size;
        $this->format = $format;
        $this->spotifyUri = $spotifyUri;
    }

    /**
     * @psalm-param self::BAR_COLOR_* $barColor
     * @psalm-param self::FORMAT_* $format
     */
    public static function create(
        string $backgroundColor,
        string $barColor,
        int $size,
        string $format,
        string $spotifyUri
    ): self {
        Assert::stringNotEmpty($backgroundColor);
        Assert::inArray($barColor, self::ALLOWED_BAR_COLORS);
        Assert::positiveInteger($size);
        Assert::inArray($format, self::ALLOWED_FORMAT);
        Assert::stringNotEmpty($spotifyUri);

        return new self($backgroundColor, $barColor, $size, $format, $spotifyUri);
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getBackgroundColor(): string
    {
        return $this->backgroundColor;
    }

    /**
     * @psalm-return self::BAR_COLOR_*
     */
    public function getBarColor(): string
    {
        return $this->barColor;
    }

    /**
     * @psalm-return positive-int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @psalm-return self::FORMAT_*
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getSpotifyUri(): string
    {
        return $this->spotifyUri;
    }
}
