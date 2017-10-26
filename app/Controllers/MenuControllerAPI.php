<?php
declare(strict_types = 1);
/**
 * Контроллер управления пользователями
 */

namespace NRViewer\Controllers;


/**
 * Class MenuControllerAPI
 * @package NRViewer\Controllers
 */
class MenuControllerAPI extends MenuController
{

    /** @noinspection PhpMissingParentCallCommonInspection */
    public function beforeroute(): void
    {

    }

    /** @noinspection PhpMissingParentCallCommonInspection */
    public function afterRoute(): void
    {

    }

    public function list(): void
    {

        parent::list();
        $data = $this->f3->get('tableItems');

        echo \json_encode($data);


    }


}
