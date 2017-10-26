<?php
declare(strict_types = 1);
/**
 * Контроллер управления группами потоков
 */

namespace NRViewer\Controllers;

use NRViewer\Models\FluxesGroup;

/**
 * Class FluxesGroupController
 * @package NRViewer\Controllers
 */
class FluxesGroupController extends Controller
{
    /**
     * FluxesGroupController constructor.
     * @param $f3
     */
    public function __construct($f3)
    {
        parent::__construct($f3);
        //Создаем обьект-модель групп потоков
        $this->model = new FluxesGroup($this->db);
    }

    /**
     * @param int $id
     */
    public function edit(int $id): void
    {
        $this->f3->set('add', 'fluxesgroup/add.html');
        parent::edit($id);
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
            'Была изменена группа потоков  - ' . $post['Caption'] . ' ID - ' . $post['ID']);
        $this->list();
    }

    /**
     * Вывод списка групп потоков
     *
     */
    public function list(): void
    {
        $groups = $this->model->all();

        $this->f3->set('tableItems', $groups);
        $this->f3->set('tableheader', 'fluxesgroup/tableheader.html', 600);
        $this->f3->set('tablebody', 'fluxesgroup/tablebody.html', 30);
        $this->f3->set('view', 'admin/layout/list.html');
        $this->f3->set('title', 'Управление группировкой потоков');
        $this->f3->set('titleDescription', '');
    }
}