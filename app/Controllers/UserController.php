<?php
declare(strict_types = 1);
/**
 * Контроллер управления пользователями
 */

namespace NRViewer\Controllers;

use NRViewer\Models\User;

/**
 * Class UserController
 * @package NRViewer\Controllers
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     * @param $f3
     */
    public function __construct($f3)
    {
        parent::__construct($f3);
        //Создаем обьект-модель пользователя
        $this->model = new User($this->db);
    }

    /**
     * @param int $id
     */
    public function edit(int $id): void
    {
        $this->f3->set('add', 'admin/users/add.html');
        parent::edit($id);
    }

    /**
     * @param int $id
     * @param $model
     */
    public function delete(int $id, $model): void
    {
        $this->f3->set(
            'lastevent',
            'Был удален пользователь Login - ' . $this->f3->get('POST.Login') . ' ID - ' . $id);
        parent::delete($id, $model);
    }

    /**
     * @param array $post
     * @param $model
     */
    public function save(array $post, $model): void
    {
        parent::save($post,$model);
        $this->f3->set(
            'lastevent',
            'Был изменен пользователь Login - ' . $post['Login'] . ' ID - ' . $post['ID']);

    }

    /**
     * Вывод списка всех пользователей
     *
     */
    public function list(): void
    {

        $this->f3->set('tableItems', $this->model->all(),30);
        $this->f3->set('title', 'Управление пользователями');
        $this->f3->set('titleDescription', 'Создание и редактирование пользователей');
        $this->f3->set('tableheader', 'admin/users/tableheader.html', 600);
        $this->f3->set('tablebody', 'admin/users/tablebody.html', 30);
        $this->f3->set('view', 'admin/layout/list.html');

    }
}
