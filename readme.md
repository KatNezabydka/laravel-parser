<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## Старт
1) <code>composer install</code>
2) создать файл с настройками <code>.env</code> (настроить конфигурацию) 
3) <code>php artisan migrate</code>

## Запуск парсера

Сайт взять в качестве примера - https://peony.ua/

Две команды доступны в консоле:

### <code>php artisan category:save</code>

Автоматически парсит все категории на сайте и сохраняет их в бд

### <code>php artisan parser:start {from?} {count?}</code>

<code>from</code> : С какого элемента начать парсить <br>
<code>count</code> : Сколько элементов спарсить

Парсит все товары по категориям, заданным в файле настройки конфигурации, и сохраняет их в бд.
По умолчанию параметры <code>from</code> и <code>count</code> берутся из файла настройки конфигурации


### Конфигурация

Файл настройки конфигураций находится по адресу <code>config/settings</code>
 <code>count_product_from</code> - С какого элемента начинать парсить товары<br>
 <code>count_product_count</code> - Количество спарсеных товаров за раз<br>
 <code>categories</code> - Массив с категориями товаров заданный вручную<br>
 <code>paginate_count_product</code> - Количество товаров на странице (постраничная пагинация учитывает этот параметр)<br>
 
 Если массив  <code>categories</code> пуст, парсер автоматически использует все категории, которые есть на сайте
    






