<?php
declare(strict_types = 1);

namespace NRViewer\Models;

use DB;

/** @noinspection LongInheritanceChainInspection */
class Fluxes extends DB\SQL\Mapper
{
    /**
     * Конструктор, связываем таблицу с потоками с PHP обьектами
     *
     * @param DB\SQL $db Database connection
     */
    public function __construct(DB\SQL $db)
    {
        parent::__construct($db, 'NAGIOS');
    }

    /**
     * Fetch all records
     *
     * @return array
     */
    public function all(): array
    {
        /** @noinspection UnNecessaryDoubleQuotesInspection */
        return $this->db->exec("
            SELECT 	*
			FROM	NAGIOS_CHECK_LIST
			ORDER BY ID
        ",null,1);
    }

    /**
     * @param array $table
     */
    public function add(array $table)
    {
        $this->db->exec("
                         INSERT INTO NAGIOS_CHECK_LIST
                              (
				              CAPTION,
				              ACTIVE,
				              DESCRIPTION
				              )
				              VALUES
			                  (
			                    '{$table['Caption']}',
				                'O',
				                '{$table['Description']}'
			                  )
			");
    }

    /**
     * @param array $table
     */
    public function saveToDB(array $table)
    {
        $this->db->exec("
                                 UPDATE NAGIOS_CHECK_LIST 
                                    SET 
                                      CAPTION         = '{$table['Caption']}',
                                      ACTIVE          = 'O',
                                      DESCRIPTION     = '{$table['Description']}'
                                    WHERE ID          = '{$table['ID']}'                                      
            ");
    }

}
