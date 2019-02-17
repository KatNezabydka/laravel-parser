<?php

namespace App\Console\Commands;

use App\Category;
use App\Parser;
use App\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class StartParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:start {from?}{count?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description ='parser:start
                        {from : С какого элемента начать парсить}
                        {count : Сколько элементов спарсить}';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $from = $this->argument('from') ?? Config::get('settings.count_product_from');
        $count = $this->argument('count') ?? Config::get('settings.count_product_count') ;

        // Получили список всех продуктов с учетом пагинации с категорий (по умолчанию берутся те, что в настройках)
        $product_list = Product::getInstance()->getProductUrl($from,$count);
        Product::getInstance()->saveProducts($product_list);

        echo 'DONE';
    }
}
