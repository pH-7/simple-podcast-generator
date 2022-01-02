<?php
/**
 * Copyright (c) Pierre-Henry Soria <hi@pH7.me>
 * MIT License - https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace PierreHenry\PodcastGenerator\Tests\Unit\Podcast\Feed;

use PHPUnit\Framework\TestCase;
use PierreHenry\PodcastGenerator\Podcast\Feed\Generator;

final class GeneratorTest extends TestCase
{
    private Generator $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = new Generator(UNIT_TEST_ROOT_PATH . 'dataset/files', 'http://localhost:2021');
    }

    public function testOutputFeed(): void
    {
        $actual = $this->generator->outputFeed(false);

        $this->assertIsString($actual);

        $this->assertMatchesRegularExpression('/<title>/', $actual);
        $this->assertMatchesRegularExpression('/<description>/', $actual);
        $this->assertMatchesRegularExpression('/' . PODCAST_NAME . '/', $actual);
        $this->assertMatchesRegularExpression('/' . PODCAST_DESCRIPTION . '/', $actual);
    }
}
