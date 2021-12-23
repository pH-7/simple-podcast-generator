<?php


declare(strict_types=1);

namespace PierreHenry\PodcastGenerator\Podcast;

use JetBrains\PhpStorm\Pure;

final class File
{
    private const MP3_EXTENSION = 'mp3';
    private const MP4_EXTENSION = 'm4a';

    private const VALID_EXTENSIONS = [
        self::MP3_EXTENSION,
        self::MP4_EXTENSION
    ];

    #[Pure] public static function isValidExtension(string $file): bool
    {
        return in_array(File::getExtension($file), File::VALID_EXTENSIONS);
    }

    public static function getExtension(string $file): string
    {
        return strtolower(pathinfo($file, PATHINFO_EXTENSION));
    }
}
