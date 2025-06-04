<?php

namespace Askancy\Metacritic;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler;
use Askancy\Metacritic\Exceptions\MetacriticException;

class MetacriticScraper
{
    private const TIMEOUT = 90;
    private const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:124.0) Gecko/20100101 Firefox/124.0';

    public function fetch(string $slug): array
    {
        $url = "https://www.metacritic.com/game/{$slug}";
        $html = $this->getHtml($url);
        $score = $this->extractScore($html);

        if ($score === null) {
            throw new MetacriticException("Score not found for game: {$slug}");
        }

        return [
            'slug' => $slug,
            'url' => $url,
            'score' => $score,
        ];
    }

private function getHtml(string $url): string
{
    $client = new Client([
        'timeout' => self::TIMEOUT,
        'cookies' => new CookieJar,
        'headers' => [
            'User-Agent' => self::USER_AGENT,
            'Accept-Language' => 'en-US,en;q=0.9',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        ],
    ]);

    try {
        $response = $client->get($url);
        return $response->getBody()->getContents();
    } catch (\GuzzleHttp\Exception\GuzzleException $e) {
        throw new MetacriticException("HTTP error while accessing {$url}: " . $e->getMessage(), 0, $e);
    }
}


    private function extractScore(string $html): ?string
    {
        preg_match_all('/<script[^>]*type="application\/ld\+json"[^>]*>(.*?)<\/script>/is', $html, $matches);
        foreach ($matches[1] as $jsonChunk) {
            $jsonChunk = html_entity_decode($jsonChunk);
            $jsonLd = json_decode($jsonChunk, true);

            if (is_array($jsonLd) && $jsonLd['@type'] === 'VideoGame') {
                $value = $jsonLd['aggregateRating']['ratingValue'] ?? null;
                return is_numeric($value) ? $value : null;
            }
        }

        $crawler = new Crawler($html);
        $node = $crawler->filter('.metascore_w.xlarge.game')->first();

        return ($node->count() && is_numeric($node->text()))
            ? trim($node->text())
            : null;
    }
}