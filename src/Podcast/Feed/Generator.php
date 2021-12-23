<?php

namespace PierreHenry\PodcastGenerator\Podcast\Feed;

use PierreHenry\PodcastGenerator\Xml\Rss\Feed;

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
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->path));

        foreach ($files as $name => $value) {
            if (pathinfo($name, PATHINFO_EXTENSION) !== 'mp3' || pathinfo($name, PATHINFO_EXTENSION) !== 'm4a') {
                continue;
            }

            $this->podcastFiles[] = [
                'title' => $this->getNameFromPath($name),
                'path' => $name,
                'url' => $this->baseUrl . $this->getRelativePath($name)
            ];
        }
    }

    private function getNameFromPath($name): string
    {
        return str_replace(['mp3', 'mp4'], $this->getRelativePath($name), '');
    }

    private function getRelativePath($name): string
    {
        return substr($name, strlen($this->path) + strlen('/'));
    }

    public function outputFeed()
    {
        $feed = new Feed('Podcast Name', 'http://localhost');
        $feed->setHeaders();
        $feed->generate($this->podcastFiles);
        $feed->saveXML();
    }
}
