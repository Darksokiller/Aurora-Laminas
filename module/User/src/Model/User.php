<?php
namespace User\Model;

use Application\Model\RowGateway\ApplicationRowGateway as Row;
use Laminas\Db\Sql\Sql;

class User extends Row
{
    public function __construct($primaryKeyColumn = 'id', $table = 'user', $adapterOrSql = null)
    {
        parent::__construct($primaryKeyColumn, $table, $adapterOrSql);
    }
}