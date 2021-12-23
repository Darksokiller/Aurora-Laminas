<?php
namespace User\Model;
use Application\Model\AbstractModel;
use RuntimeException;
use Laminas\Session;
use User\Model\User as User;
use User\Model\UserTable as UserTable;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Validator\EmailAddress as emailValidater;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;
use Laminas\Authentication\AuthenticationService as AuthService;
use Laminas\Authentication\Result;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Sql\Select;

class ProfileTable extends TableGateway
{
    protected $userTable;
    protected $user;
    
    public function fetchByColumn($column, $value)
    {
        $column = (string) $column;
        $rowset = $this->select([$column => $value]);
        $row = $rowset->current();
        //unset($row->password);
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with column: ' . $column . ' with value: ' . $value));
        }
        
        return $row;
    }
}