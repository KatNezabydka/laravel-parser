<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;

class SaveCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        // Если нужно спарсить категории с сайта и сохранить их в бд автоматически
        // Получаем ссылки на категории
        $categories = Category::getInstance()->getCategories();
        //Сохраняем их в бд
        Category::getInstance()->saveCategories($categories);
        echo 'DONE';

    }
}
