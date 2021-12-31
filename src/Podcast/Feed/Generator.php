<?php
/**
 * Copyright (c) Pierre-Henry Soria <hi@pH7.me>
 * MIT License - https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace PierreHenry\PodcastGenerator\Podcast\Feed;

use PierreHenry\PodcastGenerator\Podcast\File;
use PierreHenry\PodcastGenerator\Xml\Rss\Feed;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Generator
{
    private const META_TXT_FILE_EXT = '.meta.txt';

    private string $audioFilesPath;
    private string $baseUrl;
    private array $podcastFiles = [];

    public function __construct(string $audioFilesPath, string $baseUrl)
    {
        $this->audioFilesPath = $audioFilesPath;
        $this->baseUrl = $baseUrl;

        $this->collectAudioFiles();
    }

    private function collectAudioFiles(): void
    {
        $recursiveDirectory = new RecursiveDirectoryIterator($this->audioFilesPath);

        foreach (new RecursiveIteratorIterator($recursiveDirectory) as $file => $key) {
            if (File::isValidExtension($file)) {
                $this->podcastFiles[] = [
                    'title' => $this->getNameFromPath($file),
                    'path' => $file,
                    'url' => $this->baseUrl . '/audio-files/' . $this->getRelativePath($file),
                    'description' => $this->retrieveAudioDescription($file)
                ];
            }
        }
    }

    private function getNameFromPath(string $file): string
    {
        $name = $this->getRelativePath($file);
        $name = str_replace([...File::SUPPORTED_EXTENSIONS, '.'], '', $name);
        $name = str_replace('-', ' ', $name);

        return $name;
    }

    private function getRelativePath(string $file): string
    {
        return substr($file, strlen($this->audioFilesPath) + strlen('/'));
    }

    private function retrieveAudioDescription(string $file): string
    {
        return is_file($this->audioFilesPath . DIRECTORY_SEPARATOR . $this->getMetaTxtFile($file)) ?
            file_get_contents($this->audioFilesPath . DIRECTORY_SEPARATOR . $this->getMetaTxtFile($file)) :
            PODCAST_DESCRIPTION;
    }

    private function getMetaTxtFile(string $file): string
    {
        $file = $this->getRelativePath($file);
        return str_replace([...File::SUPPORTED_EXTENSIONS, '.'], '', $file) . self::META_TXT_FILE_EXT;
    }

    public function outputFeed(): string|bool
    {
        $feed = new Feed(PODCAST_NAME, ROOT_URL, PODCAST_DESCRIPTION);
        $feed->setHeaders();
        $feed->generate($this->podcastFiles);

        return $feed->saveXML();
    }
}
