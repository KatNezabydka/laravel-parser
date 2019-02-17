<?php

namespace App;


class Category extends Parser
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'alias',
        'link',
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

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

    public function getCategories()
    {
        $page = $this->getCrawler($this->site);
        $categories = array();
        $page = $page->filter('ul.left-menu a');
        foreach ($page as $item) {
            $categories[] = [
                'name' => $item->textContent,
                'alias' => trim($item->getAttribute('href'), '/'),
                'link' => 'https://peony.ua' . $item->getAttribute('href'),
            ];
        }
        $categories = array_slice($categories, 0, -1);
        return $categories;
    }

    public function saveCategories($categories){
        foreach ($categories as $category)
            $this::updateOrCreate($category);
    }




}
