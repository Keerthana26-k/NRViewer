<?php
declare(strict_types = 1);
/**
 * Контроллер основной страницы
 */

namespace NRViewer\Controllers;

use NRViewer\Models\Test;
use Template;

/**
 * Class TestController
 * @package NRViewer\Controllers
 */
class TestController extends Controller
{
    /**
     * TestController constructor.
     * @param $f3
     */
    public function __construct($f3)
    {
        parent::__construct($f3);
        $this->model =new Test($this->db);
    }

    /** @noinspection PhpMissingParentCallCommonInspection */
    public function afterRoute(): void
    {

    }

    /** @noinspection PhpMissingParentCallCommonInspection */
    public function beforeroute(): void
    {

    }

    /**
     * Стартовая страница
     *
     */
    public function index()
    {

        $this->f3->set('test', 'Тестовая страница');
        $this->f3->set('title', 'Список пользователей');
        $this->f3->set('view', 'test/test.html');
        $this->getColumnNames();

        echo Template::instance()->render('layout/page.html');


    }

    /**
     * Тестовая страница
     *
     */
    public function sqlTest()
    {
        $this->f3->set('test', '');
        $this->f3->set('title', 'SQL Test');
        $this->f3->set('view', 'main/testMainController.php.html');
    }

    public function ajaxtest()
    {

        echo Template::instance()->render('test/test.html');

    }
    public function getColumnNames(){

                echo \json_encode($this->model->columns());
    }
}