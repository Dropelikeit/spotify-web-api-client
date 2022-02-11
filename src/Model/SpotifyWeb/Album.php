<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Model\SpotifyWeb;

use function array_map;
use DateTimeImmutable;
use Exception;
use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class Album
{
    /**
     * @psalm-var non-empty-string
     */
    private string $albumType;

    /**
     * @var array<int, Artist>
     * @psalm-var list<Artist>
     */
    private array $artists;

    /**
     * @var array<int, AvailableMarket>
     * @psalm-var list<AvailableMarket>
     */
    private array $availableMarkets;

    /**
     * @var array<int, ExternalUrl>
     * @psalm-var list<ExternalUrl>
     */
    private array $externalUrls;

    /**
     * @psalm-var non-empty-string
     */
    private string $href;

    /**
     * @psalm-var non-empty-string
     */
    private string $id;

    /**
     * @var array<int, Image>
     * @psalm-var list<Image>
     */
    private array $images;

    /**
     * @psalm-var non-empty-string
     */
    private string $name;

    private DateTimeImmutable $releaseDate;

    /**
     * @psalm-var non-empty-string
     */
    private string $releaseDatePrecision;

    /**
     * @psalm-var positive-int
     */
    private int $totalTracks;

    /**
     * @psalm-var non-empty-string
     */
    private string $type;

    /**
     * @psalm-var non-empty-string
     */
    private string $uri;

    /**
     * @psalm-param non-empty-string $albumType
     * @param array<int, Artist> $artists
     * @psalm-param list<Artist> $artists
     * @param array<int, AvailableMarket> $availableMarkets
     * @psalm-param list<AvailableMarket> $availableMarkets
     * @param array<int, ExternalUrl> $externalUrls
     * @psalm-param list<ExternalUrl> $externalUrls
     * @psalm-param non-empty-string $href
     * @psalm-param non-empty-string $id
     * @param array<int, Image> $images
     * @psalm-param list<Image> $images
     * @psalm-param non-empty-string $name
     * @psalm-param non-empty-string $releaseDatePrecision
     * @psalm-param positive-int $totalTracks
     * @psalm-param non-empty-string $type
     * @psalm-param non-empty-string $uri
     */
    private function __construct(
        string $albumType,
        array $artists,
        array $availableMarkets,
        array $externalUrls,
        string $href,
        string $id,
        array $images,
        string $name,
        DateTimeImmutable $releaseDate,
        string $releaseDatePrecision,
        int $totalTracks,
        string $type,
        string $uri,
    ) {
        $this->albumType = $albumType;
        $this->artists = $artists;
        $this->availableMarkets = $availableMarkets;
        $this->externalUrls = $externalUrls;
        $this->href = $href;
        $this->id = $id;
        $this->images = $images;
        $this->name = $name;
        $this->releaseDate = $releaseDate;
        $this->releaseDatePrecision = $releaseDatePrecision;
        $this->totalTracks = $totalTracks;
        $this->type = $type;
        $this->uri = $uri;
    }

    /**
     * @param array<string, mixed> $album
     *
     * @throws Exception
     */
    public static function create(array $album): self
    {
        Assert::keyExists($album, 'album_type');
        $albumType = $album['album_type'];
        Assert::stringNotEmpty($albumType);

        Assert::keyExists($album, 'artists');
        $artists = $album['artists'];
        Assert::isArray($artists);

        Assert::keyExists($album, 'available_markets');
        $availableMarkets = $album['available_markets'];
        Assert::isArray($availableMarkets);

        Assert::keyExists($album, 'external_urls');
        $externalUrls = $album['external_urls'];
        Assert::isArray($externalUrls);

        Assert::keyExists($album, 'href');
        $href = $album['href'];
        Assert::stringNotEmpty($href);

        Assert::keyExists($album, 'id');
        $id = $album['id'];
        Assert::stringNotEmpty($id);

        Assert::keyExists($album, 'images');
        $images = $album['images'];
        Assert::isArray($images);

        Assert::keyExists($album, 'name');
        $name = $album['name'];
        Assert::stringNotEmpty($name);

        Assert::keyExists($album, 'release_date');
        $releaseDateAsString = $album['release_date'];
        Assert::stringNotEmpty($releaseDateAsString);

        Assert::keyExists($album, 'release_date_precision');
        $releaseDatePrecision = $album['release_date_precision'];
        Assert::stringNotEmpty($releaseDatePrecision);

        Assert::keyExists($album, 'total_tracks');
        $totalTracks = $album['total_tracks'];
        Assert::positiveInteger($totalTracks);

        Assert::keyExists($album, 'type');
        $type = $album['type'];
        Assert::stringNotEmpty($type);

        Assert::keyExists($album, 'uri');
        $uri = $album['uri'];
        Assert::stringNotEmpty($uri);

        $releaseDate = new DateTimeImmutable($releaseDateAsString);

        $externalUrlModels = [];
        foreach ($externalUrls as $provider => $url) {
            Assert::stringNotEmpty($provider);
            Assert::stringNotEmpty($url);

            $externalUrlModels[] = ExternalUrl::create($provider, $url);
        }

        $artistModels = array_map(static function (array $artist): Artist {
            Assert::isMap($artist);

            return Artist::create($artist);
        }, $artists);
        Assert::isList($artistModels);

        $availableMarketModels = array_map(static function (string $availableMarket): AvailableMarket {
            return AvailableMarket::create($availableMarket);
        }, $availableMarkets);
        Assert::isList($availableMarketModels);

        $imageModels = array_map(static function (array $image): Image {
            Assert::isMap($image);

            return Image::create($image);
        }, $images);
        Assert::isList($imageModels);

        return new self(
            $albumType,
            $artistModels,
            $availableMarketModels,
            $externalUrlModels,
            $href,
            $id,
            $imageModels,
            $name,
            $releaseDate,
            $releaseDatePrecision,
            $totalTracks,
            $type,
            $uri,
        );
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getAlbumType(): string
    {
        return $this->albumType;
    }

    /**
     * @return array<int, Artist>
     * @psalm-return list<Artist>
     */
    public function getArtists(): array
    {
        return $this->artists;
    }

    /**
     * @return array<int, AvailableMarket>
     * @psalm-return list<AvailableMarket>
     */
    public function getAvailableMarkets(): array
    {
        return $this->availableMarkets;
    }

    /**
     * @return array<int, ExternalUrl>
     * @psalm-return list<ExternalUrl>
     */
    public function getExternalUrls(): array
    {
        return $this->externalUrls;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array<int, Image>
     * @psalm-return list<Image>
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getReleaseDate(): DateTimeImmutable
    {
        return $this->releaseDate;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getReleaseDatePrecision(): string
    {
        return $this->releaseDatePrecision;
    }

    /**
     * @psalm-return positive-int
     */
    public function getTotalTracks(): int
    {
        return $this->totalTracks;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}
