<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Symfony\Component\DomCrawler\Crawler;

class Parser extends Model
{
    protected $site = 'https://peony.ua/all/';

    public static function getInstance($params = [])
    {
        $instance = new static();
        if ($params) {
            foreach ($params as $attr => $value) {
                $instance->$attr = $value;
            }
        }

        return $instance;
    }


    protected function getCrawler($url)
    {
        $html = file_get_contents($url);
        $crawler = new Crawler($html);
        return $crawler;
    }

    protected function getPageLinks($num, $last)
    {
        $links = [];
        $count = Config::get('settings.paginate_count_product');
        $replace = $num;
        while ($replace >= $count) {
            $links[] = str_replace($num, $replace, $last);
            $replace = $replace - $count;
        }
        return $links;
    }

    protected function getLinks($url, $filter)
    {
        $page = $this->getCrawler($url);
        $links = [];
        $page = $page->filter($filter);
        foreach ($page as $item) {
            $links[trim($item->getAttribute('href'), '/')] = 'https://peony.ua' . $item->getAttribute('href');
        }
        return $links;
    }
}
