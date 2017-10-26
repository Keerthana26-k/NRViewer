<?php
declare(strict_types = 1);

namespace NRViewer\Models;

use DB;

/** @noinspection LongInheritanceChainInspection */
class FluxConfig extends DB\SQL\Mapper
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
            SELECT 	
                    ID,
                    P_KEY,
					P_VALUE,
					P_DESC
			FROM	NAGIOS_PARAM
			ORDER BY P_KEY
        ",null,1);
    }

    /**
     * @param array $table
     */
    public function add(array $table)
    {
        $this->db->exec("
                         INSERT INTO NAGIOS_PARAM
                              (
				                ID,
				                P_KEY,
				                P_VALUE,
				                P_DESC
				              )
				              VALUES
			                  (
			                    '{$table['ID']}',
				                '{$table['Key']}',
				                '{$table['Value']}',
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
                                 UPDATE NAGIOS_PARAM 
                                    SET 
                                      P_KEY         = '{$table['Key']}',
                                      P_VALUE       = '{$table['Value']}',
                                      P_DESC        = '{$table['Description']}'
                                    WHERE ID        = '{$table['ID']}'                                      
            ");
    }

}
