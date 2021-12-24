<?php

declare(strict_types=1);

namespace PierreHenry\PodcastGenerator\Podcast\Feed;

use PierreHenry\PodcastGenerator\Podcast\File;
use PierreHenry\PodcastGenerator\Xml\Rss\Feed;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Generator
{
    private string $path;
    private string $baseUrl;
    private array $podcastFiles = [];

    public function __construct(string $path, string $baseUrl)
    {
        $this->path = $path;
        $this->baseUrl = $baseUrl;

        $this->collectAudioFiles();
    }

    private function collectAudioFiles(): void
    {
        $recursiveDirectory = new RecursiveDirectoryIterator($this->path);

        foreach (new RecursiveIteratorIterator($recursiveDirectory) as $file => $key) {
            if (File::isValidExtension($file)) {
                $this->podcastFiles[] = [
                    'title' => $this->getNameFromPath($file),
                    'path' => $file,
                    'url' => $this->baseUrl . '/audio-files/' . $this->getRelativePath($file)
                ];
            }
        }
    }

    private function getNameFromPath($name): string
    {
        $name = $this->getRelativePath($name);
        $name = str_replace([...File::SUPPORTED_EXTENSIONS, '.'], '', $name);
        $name = str_replace('-', ' ', $name);

        return $name;
    }

    private function getRelativePath($name): string
    {
        return substr($name, strlen($this->path) + strlen('/'));
    }

    public function outputFeed(): string|bool
    {
        $feed = new Feed('Podcast Name', 'http://localhost');
        $feed->setHeaders();
        $feed->generate($this->podcastFiles);

        return $feed->saveXML();
    }
}
