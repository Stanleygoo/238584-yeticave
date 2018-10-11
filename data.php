<?php
// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];
$is_auth = 0;

$user_name = 'Иван'; // укажите здесь ваше имя
$user_avatar = 'img/user.jpg';





$categories = [
    "Доски и лыжи", "Крепления", "Ботинки",
    "Одежда", "Инструменты", "Разное"];
$adverts = [
    [
        'name' => "2014 Rossignol District Snowboard",
        'category' => "Доски и лыжи",
        'price' => 10999,
        'url' => "img/lot-1.jpg"
    ],
    [
        'name' => "DC Ply Mens 2016/2017 Snowboard",
        'category' => "Доски и лыжи",
        'price' => 159999,
        'url' => "img/lot-2.jpg"
    ],
    [
        'name' => "Крепления Union Contact Pro 2015 года размер L/XL",
        'category' => "Крепления",
        'price' => 8000,
        'url' => "img/lot-3.jpg"
    ],
    [
        'name' => "Ботинки для сноуборда DC Mutiny Charocal" ,
        'category' => "Ботинки",
        'price' => 10999,
        'url' => "img/lot-4.jpg"
    ],
    [
        'name' => "Куртка для сноуборда DC Mutiny Charocal",
        'category' => "Одежда",
        'price' => 7500,
        'url' => "img/lot-5.jpg"
    ],
    [
        'name' => "Маска Oakley Canopy",
        'category' => "Разное",
        'price' => 5400,
        'url' => "img/lot-6.jpg"
    ]
];

date_default_timezone_set("Europe/Moscow");

/* Формирование массивов с данными результатов SQL-запросов */
$con = mysqli_connect("localhost", "root", "PasswordforMySQL","Yeticave");

mysqli_set_charset($con, "utf8");

$categories_query="SELECT id, name FROM categories GROUP BY name;";

$categories_result=mysqli_query($con, $categories_query);

if(!$categories_result) {
    $error = mysqli_error($con);
    print("Ошибка MySQL: " . $error);
    die();
}

$categories_query_array=mysqli_fetch_all($categories_result, MYSQLI_ASSOC);

$newlots_query="SELECT lots.id AS lot_id, lots.name, lots.start_price AS price, lots.image AS url, MAX(bets.price) AS price_now, 
COUNT(bets.price) AS bets_numbers, creation_date_time, categories.name AS category, end_date_time
FROM lots 
LEFT OUTER JOIN bets ON lots.id=bets.lot_id 
JOIN categories ON lots.category_id=categories.id WHERE end_date_time>CURRENT_DATE GROUP BY lots.name 
ORDER BY creation_date_time DESC;";

$newlots_result=mysqli_query($con, $newlots_query);

if(!$newlots_result) {
    $error = mysqli_error($con);
    print("Ошибка MySQL: " . $error);
    die();
}

$newlots_query_array=mysqli_fetch_all($newlots_result, MYSQLI_ASSOC);



