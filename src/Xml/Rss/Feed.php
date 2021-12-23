<?php

declare(strict_types=1);

namespace PierreHenry\PodcastGenerator\Xml\Rss;

use DOMDocument;
use DOMElement;
use DOMText;

class Feed extends DOMDocument
{
    private const DOCUMENT_VERSION = '2.0';

    private DOMElement $channelElement;

    public function __construct(string $title, string $link)
    {
        // Call the parent constructor (DomDocument)
        parent::__construct();

        $rssElement = new DOMElement('rss');
        $this->appendChild($rssElement);
        $rssElement->setAttribute('version', self::DOCUMENT_VERSION);
        $this->channelElement = new DOMElement('channel');
        $rssElement->appendChild($this->channelElement);
        $titleElement = new DOMElement('title');
        $this->channelElement->appendChild($titleElement);
        $titleElement->appendChild(new DOMText($title));
        $this->channelElement->appendChild(new DOMElement('description'));
        $this->channelElement->appendChild(new DOMElement('link', $link));

        $this->channelElement;
    }

    public function generate(array $files): void
    {
        foreach ($files as $file) {
            $itemElement = new DOMElement('item');
            $this->channelElement->appendChild($itemElement);
            $titleElement = new DOMElement('title');
            $itemElement->appendChild($titleElement);
            $titleElement->appendChild(new DOMText($file['title']));
            $itemElement->appendChild(new DOMElement('description'));
            $itemElement->appendChild(new DOMElement('link', $file['url']));
            $itemElement->appendChild(new DOMElement('guid', $file['url']));
            $enclosureElement = new DOMElement('enclosure');
            $itemElement->appendChild($enclosureElement);
            $enclosureElement->setAttribute('type', 'audio/mpeg');
            $enclosureElement->setAttribute('length', (string)filesize($file['path']));
        }
    }

    public function setHeaders(): void
    {
        header('Content-Type: application/rss+xml');
    }
}
