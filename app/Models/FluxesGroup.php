<?php
declare(strict_types = 1);

namespace NRViewer\Models;

use DB;

/** @noinspection LongInheritanceChainInspection */
class FluxesGroup extends DB\SQL\Mapper
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
        SELECT	g.ID			ID,
					g.CAPTION		CAPTION,
					g.DESCRIPTION	DESCRIPTION,
					to_char(wm_concat (DISTINCT C.CAPTION))  FLUXES
			FROM	NAGIOS_CHGROUP g
					LEFT OUTER JOIN	NAGIOS_CHGR cg
						ON			cg.ID_CHGROUP = g.ID
					LEFT OUTER JOIN	NAGIOS_CHECK_LIST c
						ON			c.id = cg.ID_CHECK
						GROUP BY	g.id,
						g.caption,
						g.description
        ");
    }

    /**
     * @param array $table
     */
    public function add(array $table)
    {
        $this->db->exec("
                         INSERT INTO NAGIOS_CHGROUP
                              (
				                CAPTION,
				                DESCRIPTION
				              )
				              values
			                  (
			                    '{$table['Title']}',
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
                                 UPDATE NAGIOS_CHGROUP 
                                    SET 
                                      CAPTION       = '{$table['Caption']}',
                                      DESCRIPTION   = '{$table['Description']}'
                                    WHERE ID        = '{$table['ID']}'                                      
            ");
    }

}
