<?php

namespace App;


use Illuminate\Support\Facades\Config;

class Product extends Parser
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'code',
        'category_alias',
        'price_opt',
        'price_retail',
        'textile',
        'url',
    ];


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

    public function getProductUrl($from , $to){

        $config_category_list = Config::get('settings.categories');
        $product_urls = array();
        // По входным категориям получаем список на все продукты
        if (isset($config_category_list) && count($config_category_list) > 0)
            foreach($config_category_list as $url)
                $product_urls = $this->getProductList($url);
        else {
            // Получаем href всех категорий
            $links_category =array_slice($this->getLinks($this->site, 'ul.left-menu a'), 0, -1);
            foreach ($links_category as $url)
                $product_urls = $this->getProductList($url);
        }
        $product_urls = array_slice($product_urls, $from, $to);
        return $product_urls;
    }


    public function getProductList($url){
        // Получаем список страниц если они есть и уже в каждой странице список товаров
        $page = $this->getCrawler($url);
        $page = $page->filter('.pager .pagerNum > a')->last();
        $lastlink = $page->attr('href');
        $num = trim(stristr($lastlink, '!'), '/,!');
        // Список всех ссылок на страницы товаров с учетом пагинации
        $links_page_paginate = $this->getPageLinks($num, $lastlink);

        $product_links = $this->getLinks($url, '.new-item-list a');

        foreach ($links_page_paginate as $item) {
            $product_links += $this->getLinks($item, '.new-item-list a');
        }
        return $product_links;

    }


    public function getProductInfo($url, $category)
    {
        $page = $this->getCrawler($url);
        $product['name'] = $page->filter('h1')->eq(0)->text();
        $product['code'] = explode(':', $page->filter('.quick-product-list.top > li')->eq(0)->text())[1];
        $product['category_alias'] = $category ?? '';
        $product['price_opt'] = $page->filter('.product_old_price')->attr('uah');
        $product['price_retail'] = $page->filter('.product_price.rozn')->attr('uah');
        $product['textile'] = explode(':', $page->filter('.quick-product-list.top > li')->eq(1)->text())[1];
        $product['url'] = $url;
        return $product;
    }

    public function saveProducts($urls){
        foreach ($urls as $key => $url)
            $this::updateOrCreate( $this->getProductInfo($url,explode( '/',$key)[0]));
    }
}
