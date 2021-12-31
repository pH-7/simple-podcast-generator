<?php
/**
 * Copyright (c) Pierre-Henry Soria <hi@pH7.me>
 * MIT License - https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace PierreHenry\PodcastGenerator\Unit\Test\Podcast;

use PHPUnit\Framework\TestCase;
use PierreHenry\PodcastGenerator\Podcast\File;

class FileTest extends TestCase
{
    /**
     * @dataProvider validFilesProvider
     */
    public function testFileIsValid(string $filename): void
    {
        $actual = File::isValidExtension($filename);

        $this->assertTrue($actual);
    }

    /**
     * @dataProvider invalidFilesProvider
     */
    public function testFileIsInvalid(string $filename): void
    {
        $actual = File::isValidExtension($filename);

        $this->assertFalse($actual);
    }

    public function validFilesProvider(): array
    {
        return [
            ['myfile.mp3'],
            ['audio-podcast.m4a']
        ];
    }

    public function invalidFilesProvider(): array
    {
        return [
            [''],
            ['audio-podcast.mp4'],
            ['audio-podcast.mov'],
            ['podcast-file'],
            ['.'],
        ];
    }
}
