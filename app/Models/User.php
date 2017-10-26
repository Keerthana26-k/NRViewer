<?php
declare(strict_types = 1);

namespace NRViewer\Models;

use DB;

/** @noinspection LongInheritanceChainInspection */
class User extends DB\SQL\Mapper
{
    /**
     * Конструктор, связываем таблицу с пользователями с PHP обьектами
     *
     * @param DB\SQL $db Database connection
     */
    public function __construct(DB\SQL $db)
    {
        parent::__construct($db, 'INTERFACE_USERS');
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
			SELECT	u.id	id,
					u.LOGIN	LOGIN,
					u.email email,
					u.passwd passwd,
					to_char(wm_concat (DISTINCT g.name)) AS groups
			FROM	interface_users u
					LEFT OUTER JOIN	interface_ug ug
						ON			ug.id_user = u.id
					LEFT OUTER JOIN	interface_groups g
						ON			ug.id_group = g.id  GROUP BY	u.id,
						u.LOGIN, u.email, u.passwd ");
    }

    /**
     * Fetch one record by id records
     *
     * @param int $id User id
     *
     * @return array
     */
    public function getById($id): array
    {
        /** @noinspection PassingByReferenceCorrectnessInspection */
        return \array_shift(
            $this->db->exec("
                                 SELECT * 
                                 FROM INTERFACE_USERS 
                                 WHERE ID='$id'
            "));
    }

    /**
     * @param array $table
     */
    public function add(array $table)
    {
        $this->db->exec("
                         INSERT INTO INTERFACE_USERS
                              (
				                LOGIN,
				                EMAIL,
				                PASSWD
				                )
			             VALUES 
			                  (
			                    '{$table['Login']}',
			                    '{$table['Email']}',
			                    '{$table['Password']}'
			                  )
			");
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->db->exec("
                                 DELETE  FROM INTERFACE_USERS 
                                 WHERE ID='$id'
        ");
    }

    /**
     * @param array $table
     * @internal param int $id
     * @internal param string $LOGIN
     * @internal param string $email
     * @internal param string $PASSWORD
     * @internal param array $groups
     * @internal param $userData
     */
    public function saveToDB(array $table)
    {
        $this->db->exec("
                                 UPDATE INTERFACE_USERS 
                                    SET 
                                      LOGIN    = '{$table['Login']}',
                                      EMAIL    = '{$table['Email']}',
			                          PASSWD   = '{$table['Password']}'
                                    WHERE ID   = '{$table['ID']}'                                      
            ");
    }
}
