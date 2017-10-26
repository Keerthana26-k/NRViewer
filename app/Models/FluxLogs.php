<?php
declare(strict_types = 1);

namespace NRViewer\Models;

use DB;

/** @noinspection LongInheritanceChainInspection */
class FluxLogs extends DB\SQL\Mapper
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
     * @return array
     */
    public function all(): array
    {
        $today = new \DateTime();
        $today->setDate(2017,10,4);
        return $this->allToday($today->format('d/m/Y'));
    }

    /**
     * Fetch all records with today date
     *
     * @param string $dateTimeBegin
     * @return array
     */
    public function allToday(string $dateTimeBegin): array
    {

        /** @noinspection UnNecessaryDoubleQuotesInspection */
        return $this->db->exec("
            SELECT	 DISTINCT 
                    clist.id			id_check,
					clog.id_log			id_log,
					clist.caption		caption,
					clist.description	description,
					clog.usr			usr,
					to_char(clog.dt_begin, 'DD/MM/YYYY HH24:MI:SS')		dt_begin,
					to_char(clog.dt_end, 'DD/MM/YYYY HH24:MI:SS')		dt_end,
					clog.sh_log			sh_log,
					clog.status			status
					
			FROM	NAGIOS_CHGROUP grp
					INNER JOIN	 NAGIOS_CHGR grpch
						ON		grp.id = grpch.id_chgroup
					INNER JOIN	 NAGIOS_CHECK_LIST clist
						ON		grpch.id_check = clist.id
					INNER JOIN	 NAGIOS_CHECK_LOG clog
						ON		clist.id = clog.id_check
						and to_char(clog.dt_begin, 'DD/MM/YYYY HH24:MI:SS') like '%{$dateTimeBegin}%' 
						ORDER BY	dt_begin
        ");
    }



}
