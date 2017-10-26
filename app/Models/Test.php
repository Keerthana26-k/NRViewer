<?php
declare(strict_types = 1);

namespace NRViewer\Models;

use DB;

/** @noinspection LongInheritanceChainInspection */
class Test extends DB\SQL\Mapper
{
    /**
     * Конструктор, связываем таблицу с пользователями с PHP обьектами
     *
     * @param DB\SQL $db Database connection
     */
    public function __construct(DB\SQL $db)
    {
        parent::__construct($db, 'NAGIOS');
    }

    /**
     * @return array
     */
    public function columns()
    {
        return \array_reverse($this->db->exec("
        SELECT  col.column_name
        FROM ALL_TAB_COLUMNS col
        WHERE col.TABLE_NAME = 'MENU'
        "));
    }
}
