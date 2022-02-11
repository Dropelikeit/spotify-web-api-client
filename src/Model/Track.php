<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Model;

use function array_map;
use MarcelStrahl\SpotifyApiClient\Model\SpotifyWeb\Album;
use MarcelStrahl\SpotifyApiClient\Model\SpotifyWeb\Artist;
use MarcelStrahl\SpotifyApiClient\Model\SpotifyWeb\AvailableMarket;
use MarcelStrahl\SpotifyApiClient\Model\SpotifyWeb\ExternalId;
use MarcelStrahl\SpotifyApiClient\Model\SpotifyWeb\ExternalUrl;
use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class Track
{
    /**
     * @psalm-var non-empty-string
     */
    private string $id;

    /**
     * @psalm-var non-empty-string
     */
    private string $name;

    private bool $isLocal;

    private int $popularity;

    private ?string $previewUrl;

    private int $trackNumber;

    /**
     * @psalm-var non-empty-string
     */
    private string $type;

    /**
     * @psalm-var non-empty-string
     */
    private string $uri;

    /**
     * @psalm-var non-empty-string
     */
    private string $href;

    private Album $album;

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

    private int $discNumber;

    private int $durationInMilliseconds;

    private bool $explicit;

    /**
     * @var array<int, ExternalId>
     * @psalm-var list<ExternalId>
     */
    private array $externalIds;

    /**
     * @var array<int, ExternalUrl>
     * @psalm-var list<ExternalUrl>
     */
    private array $externalUrls;

    /**
     * @psalm-param non-empty-string $id
     * @psalm-param non-empty-string $name
     * @psalm-param non-empty-string $type
     * @psalm-param non-empty-string $uri
     * @psalm-param non-empty-string $href
     * @param array<int, Artist> $artists
     * @psalm-param list<Artist> $artists
     * @param array<int, AvailableMarket> $availableMarkets
     * @psalm-param list<AvailableMarket> $availableMarkets
     * @param array<int, ExternalUrl> $externalUrls
     * @psalm-param list<ExternalUrl> $externalUrls
     * @param array<int, ExternalId> $externalIds
     * @psalm-param list<ExternalId> $externalIds
     */
    private function __construct(
        string $id,
        string $name,
        bool $isLocal,
        int $popularity,
        int $trackNumber,
        string $type,
        string $uri,
        string $href,
        Album $album,
        array $artists,
        array $availableMarkets,
        int $discNumber,
        int $durationInMilliseconds,
        bool $explicit,
        array $externalUrls,
        array $externalIds,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->isLocal = $isLocal;
        $this->popularity = $popularity;
        $this->trackNumber = $trackNumber;
        $this->type = $type;
        $this->uri = $uri;
        $this->href = $href;
        $this->previewUrl = null;
        $this->album = $album;
        $this->artists = $artists;
        $this->availableMarkets = $availableMarkets;
        $this->discNumber = $discNumber;
        $this->durationInMilliseconds = $durationInMilliseconds;
        $this->explicit = $explicit;
        $this->externalUrls = $externalUrls;
        $this->externalIds = $externalIds;
    }

    /**
     * @param array<string, mixed> $trackResponse
     */
    public static function create(array $trackResponse): self
    {
        Assert::keyExists($trackResponse, 'id');
        $id = $trackResponse['id'];
        Assert::stringNotEmpty($id);

        Assert::keyExists($trackResponse, 'name');
        $name = $trackResponse['name'];
        Assert::stringNotEmpty($name);

        Assert::keyExists($trackResponse, 'is_local');
        $isLocal = $trackResponse['is_local'];
        Assert::boolean($isLocal);

        Assert::keyExists($trackResponse, 'href');
        $href = $trackResponse['href'];
        Assert::stringNotEmpty($href);

        Assert::keyExists($trackResponse, 'popularity');
        $popularity = $trackResponse['popularity'];
        Assert::integer($popularity);

        Assert::keyExists($trackResponse, 'preview_url');
        $previewUrl = $trackResponse['preview_url'];
        Assert::nullOrString($previewUrl);

        Assert::keyExists($trackResponse, 'track_number');
        $trackNumber = $trackResponse['track_number'];
        Assert::integer($trackNumber);

        Assert::keyExists($trackResponse, 'type');
        $type = $trackResponse['type'];
        Assert::stringNotEmpty($type);

        Assert::keyExists($trackResponse, 'uri');
        $uri = $trackResponse['uri'];
        Assert::stringNotEmpty($uri);

        Assert::keyExists($trackResponse, 'album');
        $album = $trackResponse['album'];
        Assert::isArray($album);
        Assert::isMap($album);

        Assert::keyExists($trackResponse, 'artists');
        $artists = $trackResponse['artists'];
        Assert::isArray($artists);

        Assert::keyExists($trackResponse, 'available_markets');
        $availableMarkets = $trackResponse['available_markets'];
        Assert::isArray($availableMarkets);

        Assert::keyExists($trackResponse, 'disc_number');
        $discNumber = $trackResponse['disc_number'];
        Assert::integer($discNumber);

        Assert::keyExists($trackResponse, 'duration_ms');
        $durationMs = $trackResponse['duration_ms'];
        Assert::integer($durationMs);

        Assert::keyExists($trackResponse, 'explicit');
        $explicit = $trackResponse['explicit'];
        Assert::boolean($explicit);

        Assert::keyExists($trackResponse, 'external_ids');
        $externalIds = $trackResponse['external_ids'];
        Assert::isArray($externalIds);
        Assert::isMap($externalIds);

        Assert::keyExists($trackResponse, 'external_urls');
        $externalUrls = $trackResponse['external_urls'];
        Assert::isArray($externalUrls);
        Assert::isMap($externalUrls);

        $externalIdModels = [];
        foreach ($externalIds as $source => $identifier) {
            Assert::stringNotEmpty($identifier);

            $externalIdModels[] = ExternalId::create($source, $identifier);
        }

        $externalUrlModels = [];
        foreach ($externalUrls as $provider => $url) {
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

        $instance = new self(
            $id,
            $name,
            $isLocal,
            $popularity,
            $trackNumber,
            $type,
            $uri,
            $href,
            Album::create($album),
            $artistModels,
            $availableMarketModels,
            $discNumber,
            $durationMs,
            $explicit,
            $externalUrlModels,
            $externalIdModels,
        );

        if ($previewUrl !== null) {
            $instance->previewUrl = $previewUrl;
        }

        return $instance;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function isLocal(): bool
    {
        return $this->isLocal;
    }

    public function getPopularity(): int
    {
        return $this->popularity;
    }

    public function getPreviewUrl(): ?string
    {
        return $this->previewUrl;
    }

    public function getTrackNumber(): int
    {
        return $this->trackNumber;
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

    /**
     * @psalm-return non-empty-string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    public function getAlbum(): Album
    {
        return $this->album;
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

    public function getDiscNumber(): int
    {
        return $this->discNumber;
    }

    public function getDurationInMilliseconds(): int
    {
        return $this->durationInMilliseconds;
    }

    public function isExplicit(): bool
    {
        return $this->explicit;
    }

    /**
     * @return array<int, ExternalId>
     * @psalm-return list<ExternalId>
     */
    public function getExternalIds(): array
    {
        return $this->externalIds;
    }

    /**
     * @return array<int, ExternalUrl>
     * @psalm-return list<ExternalUrl>
     */
    public function getExternalUrls(): array
    {
        return $this->externalUrls;
    }
}
