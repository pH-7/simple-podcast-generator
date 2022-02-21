<?php
/**
 * Copyright (c) Pierre-Henry Soria <hi@pH7.me>
 * MIT License - https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace PierreHenry\PodcastGenerator\Tests\Unit\Podcast\Xml\Rss;

use PHPUnit\Framework\TestCase;
use PierreHenry\PodcastGenerator\Xml\Rss\Feed;

final class FeedTest extends TestCase
{
    private Feed $feed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->feed = new Feed('Dummy Title', 'http://localhost', 'Dummy Description');
    }

    public function testFeed(): void
    {
        $data = [
            [
                'title' => 'Title',
                'path' => UNIT_TEST_ROOT_PATH . 'dataset/files/audio.mp3',
                'url' => 'http://localhost',
                'description' => 'Description'
            ]
        ];

        $this->feed->generate($data);
        $actual = $this->feed->saveXML();

        $this->assertIsString($actual);
        $this->assertMatchesRegularExpression('/<title>/', $actual);
        $this->assertMatchesRegularExpression('/<description>/', $actual);
        $this->assertMatchesRegularExpression('/Title/', $actual);
        $this->assertMatchesRegularExpression('/Description/', $actual);
    }
}
