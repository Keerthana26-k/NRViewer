<?php
declare(strict_types = 1);
/**
 *
 *
 *  Основной класс контроллера
 *
 */

namespace NRViewer\Controllers;

use DB;
use Template;


/**
 * Class Controller
 * @package NRViewer\Controllers
 */

/**
 * Class Controller
 * @package NRViewer\Controllers
 */
class Controller
{
    /** @noinspection GenericObjectTypeUsageInspection */
    /**
     *  Общий обьект для всех моделей
     *
     * @var object
     */
    public $model;
    /** @noinspection GenericObjectTypeUsageInspection */

    /**
     * Global framework object
     *
     * @var object
     */
    protected $f3;
    /** @noinspection GenericObjectTypeUsageInspection */

    /**
     * Обьект подключения к базе данных
     *
     * @var object
     */
    protected $db;
    /**
     * Обьект главного меню
     *
     * @var MenuController
     */
    protected $mainMenu;
    protected $bench;
    /** @noinspection GenericObjectTypeUsageInspection */

    /**
     * Конструктор
     *
     * Здесь создаем подключение к базе данных
     *
     * @param type object
     */
    public function __construct($f3)
    {
        $this->f3 = $f3;
        /** @noinspection OffsetOperationsInspection */
        $this->db = new DB\SQL (
            'oci:dbname=//' .
            $this->f3['grappe']['1']['TNS'],
            $this->f3['grappe']['1']['LOGIN'],
            $this->f3['grappe']['1']['PASSWORD'],
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,\PDO::ATTR_PERSISTENT=>true]
        );

    }/** @noinspection ReturnTypeCanBeDeclaredInspection */

    /**
     *
     * beforeroute - метод фреймворка который срабатывает до выполнения роутинга
     *
     * В нем мы проверяем залогинен ли пользователь, если нет то отправляем на страницу логина
     *
     */
    public function beforeroute(): void
    {

        if ($this->f3->get('SESSION.user') === null) {
            $this->f3->reroute('/LOGIN');
            exit;
        }
    }

    /**
     *
     * afterRoute - метод фреймворка который срабатывает после выполнения роутинга
     *
     * В нем мы запускаем рендеринг итоговой страницы для вывода
     *
     * @return void
     */
    public function afterRoute(): void
    {

        if ($this->f3->exists('menu')) {
            $this->f3->set('menu', $this->f3->get('menu'));
        } else {
            $this->renderMenu();
        }


        echo Template::instance()->render('layout/page.html');

    }

    public function renderMenu(): void
    {
        $this->mainMenu = new MenuController($this->f3);
        $this->mainMenu->create();

    }

    public function manage(): void
    {
        switch ($this->f3->get('POST.manageMode')) {
            case 'edit':
                $this->edit((int) $this->f3->get('POST.ID'));
                break;
            case 'delete':
                $this->delete((int) $this->f3->get('POST.ID'), $this->model);
                break;
            case 'save':
                $this->save($this->f3->get('POST'), $this->model);
                break;
            case 'add':
                $this->add($this->f3->get('POST'), $this->model);
                break;
        }
    }

    /**
     * @param int $id
     */
    /**
     * @param int $id
     */
    public function edit(int $id): void
    {
        $this->f3->set('edit', true);
        $this->f3->set('editID', $id);
        $this->list();
    }

    public function list(): void
    {
    }

    /**
     * @param int $id
     * @param $model
     */
    /**
     * @param int $id
     * @param $model
     */
    public function delete(int $id, $model): void
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $model->delete($id);
        $this->list();
    }

    /**
     * @param array $post
     * @param $model
     */
    public function save(array $post, $model): void
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $model->saveToDB($post);
        $this->list();
    }

    /**
     * @param array $post
     * @param $model
     */
    public function add(array $post, $model): void
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $model->add($post);
        $this->list();
    }
}
