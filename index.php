<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: g.lebedev@auchan.ru
 * Date: 06.09.2017
 * Time: 15:02
 */
namespace NRViewer;

use Base;
use Session;


require_once 'vendor/autoload.php';

/* Инициализация F3 фреймворка */
/** @noinspection PhpVariableNamingConventionInspection */
$f3 = Base::instance();


/* Загрузка конфигурации */
$f3->config('app/Configs/config.ini');

/* Загрузка конфигурации Баз данных*/
$f3->config('app/Configs/db.ini');

/* Загрузка маршрутов */
$f3->config('app/Configs/routes.ini');


new Session();

/* Запуск приложения*/
$f3->run();


