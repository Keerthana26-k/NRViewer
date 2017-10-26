<?php
declare(strict_types = 1);
/**
 * Контроллер параметрирования
 */

namespace NRViewer\Controllers;

use NRViewer\Models\FluxConfig;

/**
 * Class FluxConfigController
 * @package NRViewer\Controllers
 */
class FluxConfigController extends Controller
{
    /**
     * FluxConfigController constructor.
     * @param $f3
     */
    public function __construct($f3)
    {
        parent::__construct($f3);
        //Создаем обьект-модель групп потоков
        $this->model = new FluxConfig($this->db);
    }

    /**
     * @param int $id
     */
    public function edit(int $id): void
    {
        $this->f3->set('add', 'fluxconfig/add.html');
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
        $this->f3->set('tableheader', 'fluxconfig/tableheader.html', 600);
        $this->f3->set('tablebody', 'fluxconfig/tablebody.html', 30);
        $this->f3->set('view', 'admin/layout/list.html');
        $this->f3->set('title', 'Параметрирование потоков'); //TODO
        $this->f3->set('titleDescription', '');
    }
}