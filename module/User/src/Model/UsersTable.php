<?php
namespace User\Model;

use RuntimeException;
use User\Model\Users as Users;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Validator\EmailAddress as emailValidater;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;

class UsersTable
{
    private $tableGateway;
    
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function login(Users $user)
    {
        
        // yes this is an anonamous function which can be used nearly anywhere
//         $validationCallback = function($password, $hash) {
//             return $this->authenticate($password, $password);
//         };

       // $hash = $this->getHashByEmail($user->email);
       // $password = $user->password;
        //var_dump($hash);
        /**
         * 
         * @var unknown $callback
         * these arguments are switched around due to the 
         * manner in which they are passed during the authentication
         * see Laminas\Authentication\CallbackCheckAdapter::authenticateValidateResult($resultIdentity)
         */
        $callback = function($hash, $password) {
            return password_verify($password, $hash);
        };
        
        $authAdapter = new AuthAdapter($this->tableGateway->getAdapter(), 
                                       'users', 
                                       'email', 
                                       'password',
                                       $callback);

        $authAdapter->setIdentity($user->email)
        ->setCredential($user->getPassword());
        
        //$select = $authAdapter->getDbSelect();
        //$select->where('active = 1');
        
        // Perform the authentication query, saving the result
        $result = $authAdapter->authenticate();
        if($result->isValid()){
            var_dump($authAdapter->getResultRowObject());
        }
        else {
            var_dump($result->getMessages());
        }
        
        //die();
    }
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    public function getHashByEmail($email)
    {
        $rowset = $this->tableGateway->select(['email' => $email]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $email
                ));
        }
        return $row->password;
    }
    public static function authenticate($password, $hash)
    {
//         $email = (string) $email;
//         $rowset = $this->tableGateway->select(['email' => $email]);
//         $row = $rowset->current();
//         if (! $row) {
//             throw new RuntimeException(sprintf(
//                 'Could not find row with identifier %d',
//                 $email
//                 ));
//         }
        return password_verify($password, $hash);
        
        //return $row;
    }
    public function getUser($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
                ));
        }
        
        return $row;
    }
    
    public function saveUser(Users $user)
    {
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password'  => $user->password,
        ];
        
        $id = (int) $user->id;
        
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }
        
        try {
            $this->getUser($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update User with identifier %d; does not exist',
                $id
                ));
        }
        
        $this->tableGateway->update($data, ['id' => $id]);
    }
    
    public function deleteUser($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
?>