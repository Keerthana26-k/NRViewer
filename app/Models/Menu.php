<?php
declare(strict_types = 1);

namespace NRViewer\Models;

use DB;

/** @noinspection LongInheritanceChainInspection */
class Menu extends DB\SQL\Mapper
{
    /**
     * Конструктор, связываем таблицу с пользователями с PHP обьектами
     *
     * @param DB\SQL $db Database connection
     */
    public function __construct(DB\SQL $db)
    {
        parent::__construct($db, 'NAGIOS.MENU');
    }

    /**
     * Fetch all records
     *
     * @return array
     */
    public function all(): array
    {
        // Получаем все записи из таблицы Menu
        return $this->db->exec("SELECT * FROM NAGIOS.MENU ORDER BY ID", null, 10);
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        $this->db->exec("
                                 DELETE  FROM NAGIOS.MENU 
                                 WHERE ID='$id' 
        ");
    }

    /**
     * @param array $table
     */
    public function saveToDB(array $table)
    {
        $this->db->exec("
                                 UPDATE NAGIOS.MENU 
                                    SET ID ='{$table['ID']}',
                                        PARENT_ID ='{$table['ParentID']}',
                                        TITLE ='{$table['Title']}',
                                        DESCRIPTION ='{$table['Description']}',
                                        LINK ='{$table['Link']}',
                                        IS_PAGE='{$table['IsPage']}',
                                        ICON='{$table['Icon']}'
                                    WHERE ID='{$table['ID']}'
                                      
            ");
    }

    /**
     * @param array $table
     */
    public function add(array $table)
    {
        $this->db->exec("
                         INSERT INTO NAGIOS.MENU
                              (
				                PARENT_ID,
				                TITLE,
				                DESCRIPTION,
				                LINK,
				                IS_PAGE,
				                ICON
				                )
			             VALUES 
			                  (	                    
			                    '{$table['ParentID']}',
			                    '{$table['Title']}',
			                    '{$table['Description']}',
			                    '{$table['Link']}',
			                    '{$table['IsPage']}',
			                    '{$table['Icon']}'
			                  )
			");
    }
}
