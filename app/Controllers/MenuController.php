<?php
declare(strict_types = 1);

namespace NRViewer\Controllers;

use Knp\Menu\Matcher\Matcher;
use Knp\Menu\MenuFactory;
use Knp\Menu\MenuItem;
use Knp\Menu\Renderer\ListRenderer;
use NRViewer\Helpers\Helpers;
use NRViewer\Models\Menu;

/**
 * Class MenuController
 * @package NRViewer\Controllers
 */
class MenuController extends Controller
{
    /**
     * MenuController constructor.
     * @param $f3
     */
    public function __construct($f3)
    {
        parent::__construct($f3);
        //Создаем обьект-модель главного меню
        $this->model = new Menu($this->db);
    }

    /**
     * @param int $id
     */
    public function edit(int $id): void
    {
        $this->f3->set('listIcons', Helpers::getIcons());
        $this->f3->set('add', 'admin/menu/add.html');
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
            'Был удален пункт меню TITLE - ' . $this->f3->get('POST.menuItemTitle') .
            ' ID - ' . $id);
        parent::delete($id, $model);
    }

    public function list(): void
    {
        $menuItems = $this->model->all();
        // Добавляем поле ParentTitle в массив полученное из ParentID
        $menuItems = $this->getParentTitle($menuItems);
        $this->f3->set('tableItems', $menuItems);
        // массив tableItems2 нужен из-за особенностей работы шаблонизатора фреймворка,
        // он идентичен tableItems
        $this->f3->set('tableItems2', $menuItems);
        $this->f3->set('tableheader', 'admin/menu/tableheader.html', 600);
        $this->f3->set('tablebody', 'admin/menu/tablebody.html', 30);
        $this->f3->set('title', 'Управление меню');
        $this->f3->set('titleDescription', 'Создание и редактирование разделов меню');
        $this->f3->set('view', 'admin/layout/list.html');
    }

    /**
     *
     * Добавляем каждому элементу меню в массиве TITLE родительского раздела в поле PARENT_TITLE
     *
     * @param array $menuItems
     * @return array
     */
    public function getParentTitle(array $menuItems): array
    {
        $arrayID = \array_column($menuItems, 'ID');
        /** @var int $row */
        $row = 0;
        foreach ($menuItems as $key => $value) {
            $parentID = \array_search($value['PARENT_ID'], $arrayID, true);
            if (!\is_bool($parentID)) {
                $menuItems[$row]['PARENT_TITLE'] = $menuItems[$parentID]['TITLE'];
            }
            $row++;
        }

        return $menuItems;
    }

    /**
     * @param array $post
     * @param $model
     */
    public function save(array $post, $model): void
    {
        $this->f3->clear('menu');
        $this->f3->set(
            'lastevent',
            'Был изменен пункт меню  - <strong>' . $post['Title'] . '</strong> c <strong>ID</strong> - ' . $post['ID']);
        parent::save($post, $model);
    }

    /**
     * @param array $post
     * @param $model
     */
    public function add(array $post, $model): void
    {
        parent::add($post, $model);
        $this->f3->set(
            'lastevent',
            'Был добавлен пункт меню  - <strong>' . $post['Title'] . '</strong>');
    }

    /**
     *
     * createMenu - метод генерации меню на сонове данных из БД
     *
     *
     * @return void
     */
    public function create(): void
    {
        // Получаем массив категорий и страниц меню отсортированных по PARENT_ID
        $menuFromDB = Helpers::createTree($this->model->all());
        // Используем бибилиотеку knp-menu
        // Создаем нужные обьекты для создания меню
        $factory = new MenuFactory();
        $renderer = new ListRenderer(new Matcher());
        // Создаем обьект меню и наполняем его данными из модели
        $menu = $factory->createItem('home');
        $menu->setChildrenAttributes([
            'class' => 'sidebar-menu'
        ]);
        $menu->addChild('ОСНОВНАЯ НАВИГАЦИЯ')->setAttribute('class', 'header');
        $this->buildMenuFromDB($menu, $menuFromDB);
        // Отправляем сгенерированное меню в переменную menu которая используется в шаблонe header
        $this->f3->set('menu', $renderer->render($menu, ['allow_safe_labels' => true, 'compressed' => false]), 10);
    }/** @noinspection MultipleReturnStatementsInspection */

    /**
     *
     * buildMenuFromDB - Рекурсивное наполнение обьекта меню данными из БД
     *
     * @param MenuItem $menu
     * @param array $arr
     * @param int $parentID
     * @return MenuItem
     */
    public function buildMenuFromDB(MenuItem $menu, array $arr, int $parentID = 0): MenuItem
    {
        //Условия выхода из рекурсии
        if (empty($arr[$parentID])) {
            return $menu;
        }
        /** @noinspection ForeachSourceInspection */
        foreach ($arr[$parentID] as $item) {
            if ($item['IS_PAGE'] === '1') {
                /** @noinspection PhpUndefinedMethodInspection */
                $menu->addChild(
                    $item['ID'], [
                    'uri' => '/' . $item['LINK'],
                    'label' => '<i class="fa ' . $item['ICON'] . '" ></i><span>' . $item['TITLE'] . '</span>',
                    'class' => 'dropdown-submenu',
                    'extras' => ['safe_label' => true]
                ]);
                $menu[$item['ID']]->setAttribute('class', 'dropdown-submenu');
            } else {
                /** @noinspection PhpUndefinedMethodInspection */
                $menu->addChild(
                    $item['ID'], [
                    'uri' => '#',
                    'label' => '<i class="fa ' . $item['ICON'] . '" ></i><span>' . $item['TITLE'] . ' <i class="fa fa-arrow-right"></i></span>',
                    'extras' => ['safe_label' => true]
                ]);
                $menu[$item['ID']]->setAttribute('class', ' treeview dropdown-submenu');
            }
            $menu[$item['ID']]->setChildrenAttributes(['class' => 'dropdown-menu']);
            //рекурсия - проверяем нет ли дочерних категорий
            $this->buildMenuFromDB($menu[$item['ID']], $arr, (int) $item['ID']);
        }

        return $menu;
    }
}
