<?php
declare(strict_types = 1);
/**
 * Контроллер параметрирования
 */

namespace NRViewer\Controllers;


use NRViewer\Models\Fluxes;

/**
 * Class FluxesController
 * @package NRViewer\Controllers
 */
class FluxesController extends Controller
{
    /**
     * FluxesController constructor.
     * @param $f3
     */
    public function __construct($f3)
    {
        parent::__construct($f3);
        //Создаем обьект-модель групп потоков
        $this->model = new Fluxes($this->db);
    }

    /**
     * @param int $id
     */
    public function edit(int $id): void
    {
        $this->f3->set('add', 'fluxes/add.html');
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
            'Был изменен параметр  - ' . $post['Key'] . ' ID - ' . $post['ID']);
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
        $this->f3->set('tableheader', 'fluxes/tableheader.html', 600);
        $this->f3->set('tablebody', 'fluxes/tablebody.html', 30);
        $this->f3->set('view', 'admin/layout/list.html');
        $this->f3->set('title', 'Управление потоками');
        $this->f3->set('titleDescription', '');
    }
}