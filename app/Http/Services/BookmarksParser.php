<?php

namespace App\Http\Services;

use Symfony\Component\DomCrawler\Crawler;

class BookmarksParser
{

    public $url;
    private $crawler;
    public $title;
    public $description;
    public $keywords;
    public $favicon;


    public function __construct($url) {
        $this->url = $url;
        $html = $this->getContent();
        $this->crawler = new Crawler($html);
        $this->title = $this->getTitle();
        $this->description = $this->getDescription();
        $this->keywords = $this->getKeywords();
        $this->favicon = $this->getFavicon();
    }

    public function toArray() {
        return [
            'title' => $this->title,
            'url' => $this->url,
            'description' => $this->description,
            'keywords' => json_encode($this->keywords),
            'favicon' => $this->favicon
        ];
    }

    protected function getContent() {
        return file_get_contents($this->url);
    }

    protected function getTitle() {
        try {
            return $this->crawler->filterXPath('//title')->text();
        } catch(\Exception $e) {
            return null;
        }
    }

    protected function getDescription() {
        try {
            return $this->crawler->filter('meta[name="description"]')->eq(0)->attr('content');
        } catch(\Exception $e) {
            return null;
        }
    }

    protected function getKeywords() {
        try {
            $keywords = $this->crawler->filter('meta[name="keywords"]')->eq(0)->attr('content');
            return explode(', ', $keywords);
        } catch(\Exception $e) {
            return null;
        }
    }

    protected function parseUrl($url) {
        return parse_url($url);
    }

    protected function getFavicon() {
        $favicon = $this->getFaviconPath();
        if($favicon) {
            return $this->storeFavicon($favicon);
        }
    }

    protected function getFaviconPath() {
        $faviconFromRootDirectory = $this->getFaviconFromRootDirectory();
        if(!$faviconFromRootDirectory) {
            $faviconFromHtml = $this->getFaviconFromHtml();
            if(!$faviconFromHtml) {
                return false;
            } else {
                return $faviconFromHtml;
            }
        } else {
            return $faviconFromRootDirectory;
        }
    }

    protected function getFaviconFromRootDirectory() {
        $url = $this->parseUrl($this->url);
        $path = $url['scheme'].'://'.$url['host'].'/favicon.ico';
        try {
            file_get_contents($path);
            return $path;
        } catch(\Exception $e) {
            return false;
        }
    }

    protected function getFaviconFromHtml() {
        $url = $this->parseUrl($this->url);
        try {
            $file = $this->crawler->filter('link[rel="icon"]')->eq(0)->attr('href');
            $path = $url['scheme'].'://'.$url['host'].$file;
            return $path;
        } catch(\Exception $e) {
            return false;
        }
    }

    protected function storeFavicon($path) {
        try {
            $filename = (string)\Str::uuid($path);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $favicon = file_get_contents($path);
            \Storage::put('favicons\\'.$filename.'.'.$extension, $favicon);
            return $filename.'.'.$extension;
        } catch(\Exception $e) {
            return null;
        }
    }
}