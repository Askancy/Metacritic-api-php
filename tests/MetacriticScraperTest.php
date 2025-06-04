<?php

use PHPUnit\Framework\TestCase;
use Askancy\Metacritic\MetacriticScraper;
use Askancy\Metacritic\Exceptions\MetacriticException;

class MetacriticScraperTest extends TestCase
{
public function testFetchReturnsScore()
{
    $scraper = new MetacriticScraper();
    $result = $scraper->fetch('elden-ring');

    $this->assertIsArray($result);
    $this->assertArrayHasKey('slug', $result);
    $this->assertArrayHasKey('url', $result);
    $this->assertArrayHasKey('score', $result);

    $this->assertSame('elden-ring', $result['slug']);
    $this->assertStringStartsWith('https://www.metacritic.com/game/elden-ring', $result['url']);
    $this->assertIsNumeric($result['score']); // accetta '96' o 96

    // Converti in JSON e validalo
    $json = json_encode($result);
    $this->assertJson($json);

    $decoded = json_decode($json, true);
    $this->assertEquals($result, $decoded); // JSON decode reversibile
}


    public function testFetchThrowsExceptionForInvalidSlug()
    {
        $this->expectException(MetacriticException::class);
        $scraper = new MetacriticScraper();
        $scraper->fetch('nonexistent-game-slug');
    }
}