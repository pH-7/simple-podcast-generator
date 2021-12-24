<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';
require __DIR__ . '/config.php';

use PierreHenry\PodcastGenerator\Podcast\Feed\Generator;

$podcastGenerator = new Generator(__DIR__ . '/audio-files', ROOT_URL);
echo $podcastGenerator->outputFeed();
