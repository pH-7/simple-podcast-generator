<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

use PierreHenry\PodcastGenerator\Podcast\Feed\Generator;

$podcastGenerator = new Generator(__DIR__ . '/audio-files', 'http://localhost:2021');
echo $podcastGenerator->outputFeed();