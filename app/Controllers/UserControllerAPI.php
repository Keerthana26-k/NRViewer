<?php
declare(strict_types = 1);
/**
 * Контроллер управления пользователями
 */

namespace NRViewer\Controllers;


/**
 * Class UserControllerAPI
 * @package NRViewer\Controllers
 */
class UserControllerAPI extends UserController
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
