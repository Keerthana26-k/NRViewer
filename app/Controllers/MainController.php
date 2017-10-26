<?php
declare(strict_types = 1);
/**
 * Контроллер основной страницы
 */

namespace NRViewer\Controllers;

/**
 * Class MainController
 * @package NRViewer\Controllers
 */
class MainController extends Controller
{
    /**
     * Стартовая страница
     *
     */
    public function index()
    {
        $this->f3->set('title', 'Добро пожаловать!');
        $this->f3->set('view', 'main/index.html');
    }
}
