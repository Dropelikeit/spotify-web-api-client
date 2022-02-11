<?php
declare(strict_types=1);

namespace MarcelStrahl\SpotifyApiClient\Model\SpotifyWeb;

use Webmozart\Assert\Assert;

/**
 * @author Marcel Strahl <info@marcel-strahl.de>
 */
final class Artist
{
    /**
     * @psalm-var non-empty-string
     */
    private string $id;

    /**
     * @psalm-var non-empty-string
     */
    private string $href;

    /**
     * @psalm-var non-empty-string
     */
    private string $name;

    /**
     * @psalm-var non-empty-string
     */
    private string $type;

    /**
     * @psalm-var non-empty-string
     */
    private string $uri;

    /**
     * @var array<int, ExternalUrl>
     * @psalm-var list<ExternalUrl>
     */
    private array $externalUrls;

    /**
     * @psalm-param non-empty-string $id
     * @psalm-param non-empty-string $href
     * @psalm-param non-empty-string $name
     * @psalm-param non-empty-string $type
     * @psalm-param non-empty-string $uri
     * @param array<int, ExternalUrl> $externalUrls
     * @psalm-param list<ExternalUrl> $externalUrls
     */
    private function __construct(string $id, string $href, string $name, string $type, string $uri, array $externalUrls)
    {
        $this->id = $id;
        $this->href = $href;
        $this->name = $name;
        $this->type = $type;
        $this->uri = $uri;
        $this->externalUrls = $externalUrls;
    }

    /**
     * @param array<string, mixed> $artist
     */
    public static function create(array $artist): self
    {
        Assert::keyExists($artist, 'external_urls');
        $externalUrls = $artist['external_urls'];
        Assert::isArray($externalUrls);
        Assert::isMap($externalUrls);

        $externalUrlModels = [];
        foreach ($externalUrls as $provider => $url) {
            Assert::stringNotEmpty($url);

            $externalUrlModels[] = ExternalUrl::create($provider, $url);
        }

        Assert::keyExists($artist, 'href');
        $href = $artist['href'];
        Assert::stringNotEmpty($href);

        Assert::keyExists($artist, 'id');
        $id = $artist['id'];
        Assert::stringNotEmpty($id);

        Assert::keyExists($artist, 'name');
        $name = $artist['name'];
        Assert::stringNotEmpty($name);

        Assert::keyExists($artist, 'type');
        $type = $artist['type'];
        Assert::stringNotEmpty($type);

        Assert::keyExists($artist, 'uri');
        $uri = $artist['uri'];
        Assert::stringNotEmpty($uri);

        return new self(
            $id,
            $href,
            $name,
            $type,
            $uri,
            $externalUrlModels,
        );
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
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getName(): string
    {
        return $this->name;
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
     * @return array<int, ExternalUrl>
     * @psalm-return list<ExternalUrl>
     */
    public function getExternalUrls(): array
    {
        return $this->externalUrls;
    }
}
