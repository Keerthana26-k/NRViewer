<?php
declare(strict_types = 1);
/**
 * Контроллер логи потоков
 */

namespace NRViewer\Controllers;

use NRViewer\Models\FluxLogs;

/**
 * Class FluxLogsController
 * @package NRViewer\Controllers
 */
class FluxLogsController extends Controller
{
    /**
     * FluxLogsController constructor.
     * @param $f3
     */
    public function __construct($f3)
    {
        parent::__construct($f3);
        //Создаем обьект-модель групп потоков
        $this->model = new FluxLogs($this->db);
    }

    /**
     * @param int $id
     */
    public function edit(int $id): void
    {
        $this->f3->set('add', 'fluxlogs/add.html');
        parent::edit($id);
    }


    /**
     * Вывод списка групп потоков
     *
     */
    public function list(): void
    {
        // Кешируем тяжелый долгий запрос. Время кеша = 60 сек
        if ($this->f3->exists('tableItems')) {
            $this->f3->set('tableItems', $this->f3->get('tableItems'));
        } else {
            $this->f3->set('tableItems', $this->model->all(), 1);
        }

        $this->f3->set('tableheader', 'fluxlogs/tableheader.html', 600);
        $this->f3->set('tablebody', 'fluxlogs/tablebody.html', 30);
        $this->f3->set('view', 'admin/layout/list.html');
        $this->f3->set('title', 'Логи потоков');
        $this->f3->set('titleDescription', '');
    }
}