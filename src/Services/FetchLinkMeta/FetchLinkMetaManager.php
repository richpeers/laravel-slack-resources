<?php

namespace Richpeers\LaravelSlackResources\Services\FetchLinkMeta;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\Log;

class FetchLinkMetaManager implements FetchLinkMeta
{
    protected $url;
    protected $client;
    protected $contents;
    protected $contentType = '';

    /**
     * @param $url
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getData($url)
    {
        $this->url = $url;

        $this->fetchContent();

        if (!$this->isWebsite()) {
            return [];
        }

        return $this->parsePage();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function fetchContent()
    {
        $client = new Client([RequestOptions::COOKIES => true]);

        $response = $client->request('GET', $this->url);

        // set content type
        $headerContentType = $response->getHeader('content-type');

        if (is_array($headerContentType) && count($headerContentType) > 0) {
            $this->contentType = current(explode(';', current($headerContentType)));
        }

        // set content
        $this->contents = (string)$response->getBody();
    }

    /**
     * @return bool
     */
    protected function isWebsite()
    {
        $len = strlen('text/');
        return (substr($this->contentType, 0, $len) === 'text/');
    }

    /**
     * @return array
     */
    protected function parsePage()
    {
        $doc = new \DOMDocument();
        @$doc->loadHTML($this->contents);

        $data = [];

        // parse meta tags
        foreach ($doc->getElementsByTagName('meta') as $meta) {

            // image
            if ($meta->getAttribute('itemprop') === 'image') {

                $data['image'] = $meta->getAttribute('content');

            } elseif ($meta->getAttribute('property') === 'og:image') {

                $data['image'] = $meta->getAttribute('content');

            } elseif ($meta->getAttribute('property') === 'twitter:image') {

                $data['image'] = $meta->getAttribute('value');
            }

            // title
            if ($meta->getAttribute('itemprop') === 'name') {

                $data['title'] = $meta->getAttribute('content');

            } elseif ($meta->getAttribute('property') === 'og:title') {

                $data['title'] = $meta->getAttribute('content');

            } elseif ($meta->getAttribute('property') === 'twitter:title') {

                $data['title'] = $meta->getAttribute('value');
            }

            // description
            if ($meta->getAttribute('itemprop') === 'description') {

                $data['title'] = $meta->getAttribute('content');
            }

            if ($meta->getAttribute('property') === 'og:description') {

                $data['description'] = $meta->getAttribute('content');
            }
        }

        // title tag
        if (empty($data['title'])) {

            foreach ($doc->getElementsByTagName('title') as $title) {
                $data['title'] = $title->nodeValue;
            }
        }

        if (empty($data['description'])) {
            foreach ($doc->getElementsByTagName('meta') as $meta) {
                if ($meta->getAttribute('name') === 'description') {
                    $data['description'] = $meta->getAttribute('content');
                }
            }
        }

        foreach ($doc->getElementsByTagName('img') as $img) {
            $data['pictures'][] = $img->getAttribute('src');
        }

        return $data;
    }
}
