<?php
declare(strict_types = 1);
/**
 * Контроллер страницы аутентификации
 */

namespace NRViewer\Controllers;

use Template;

/**
 * Class LoginController
 * @package NRViewer\Controllers
 */
class LoginController extends Controller
{
    /** @noinspection PhpMissingParentCallCommonInspection */
    /**
     * We override the beforeroute function in the `Controller` class
     * Therefore the parent behaviour will not happen
     * i.e. we do not check if there is a logged in user, because
     * no user is logged in when the LOGIN view is loaded
     *
     * @return void
     */
    public function beforeroute(): void
    {
    }/** @noinspection PhpMissingParentCallCommonInspection */

    /**
     * We override the afterroute function in the `Controller` class
     * Therefore the parent behaviour will not happen
     * i.e. we do not want to include the debug bar
     *
     * @return void
     */
    public function afterRoute(): void
    {
    }

    /**
     * Страница аутентификации пользователя
     *
     */
    public function index()
    {
        $this->f3->set('title', 'Вход в систему');
        echo Template::instance()->render('LOGIN/LOGIN.html');
    }

    /**
     * Аутентификация пользователя
     *
     */
    public function auth()
    {
        $username = $this->f3->get('POST.username');
        /** @noinspection PhpUnusedLocalVariableInspection */
        $password = $this->f3->get('POST.PASSWORD'); //TODO Сделать проверку пароля

        $this->f3->set('SESSION.user', $username);
        $this->f3->reroute('/');
    }

    public function logout()
    {
        $this->f3->set('SESSION.user', null);
        \session_destroy();
        $this->f3->reroute('/LOGIN');
    }
}
