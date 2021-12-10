<?php
namespace User\Model;

use Application\Model\AbstractModel;
use RuntimeException;
use Laminas\Session;
use User\Model\User as User;
use User\Model\Profile as Profile;
use Application\Model\LoggableEntity;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Validator\EmailAddress as emailValidater;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;
use Laminas\Authentication\AuthenticationService as AuthService;
use Laminas\Authentication\Result;
use Laminas\Db\Sql\Select as Select;
use Application\Permissions\PermissionsManager as Acl;
use Laminas\Permissions\Acl\ProprietaryInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;

class UserTable extends TableGateway
{


    public function login(User $user)
    {
        try {
            $callback = function($hash, $password) {
                return password_verify($password, $hash);
            };
            
            $authAdapter = new AuthAdapter($this->getAdapter(),
                'user',
                'email',
                'password',
                $callback);
            
            $authAdapter->setIdentity($user->email)
            ->setCredential($user->password);
            
            $select = $authAdapter->getDbSelect();
            $select->where('active = 1')->where('verified = 1');
            
            // Perform the authentication query, saving the result
            $authService = new AuthService();
            $authService->setAdapter($authAdapter);
            //$result = $authAdapter->authenticate();
            $result = $authService->authenticate();
            //var_dump($result);
            
            //var_dump($result->getMessages());
            switch ($result->getCode()) {
                
                case Result::SUCCESS:
                    //$this->logger->info('User ' . $result->userName . ' logged in.', ['userId' => $result->id, 'userName' => $result->userName]);
                    /** do stuff for successful authentication **/
                    $omitColumns = ['password'];
                    //$userSession = new Session\Container('user');
                    //$userSession->details = $authAdapter->getResultRowObject(null, $omitColumns);
                    //var_dump($authAdapter->getResultRowObject(null, $omitColumns));
                    $user = $authAdapter->getResultRowObject(null, $omitColumns);
                    //var_dump((array) $user);
                    
                    //die(__FILE__ . '::' . __LINE__);
                    return new User(null, $this, (array)$user);
                    break;
                    
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    /** do stuff for nonexistent identity **/
                    break;
                    
                case Result::FAILURE_CREDENTIAL_INVALID:
                    /** do stuff for invalid credential **/
                    break;
                    
                default:
                    /** do stuff for other failure **/
                    return false;
                    break;
            }
        } catch (Exception $e) {
        }
    }

    public function fetchAll()
    {
        return $this->select();
    }
    public function fetchByColumn($column, $value)
    {
        $column = (string) $column;
        $rowset = $this->select([$column => $value]);
        $row = $rowset->current();
        //unset($row->password);
        if (! $row) {
            throw new RuntimeException(sprintf('Could not find row with column: ' . $column . ' with value: ' . $value));
        }
        
        return new User($row);
    }
    public function getHashByEmail($email)
    {
        $rowset = $this->select(['email' => $email]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $email
                ));
        }
        return $row->password;
    }
    
    public function getCurrentUser($email)
    {
        $email = (string) $email;
        $rowset = $this->select(function(Select $select) use ($email){
            $select->where(['user.email' => $email])->join('user_profile',              // table name
                'user.id = user_profile.userId');
        });
        $row = $rowset->current();
        //var_dump($row);
        //$this->logger->info("__FILE__ __LINE__", );
        //unset($row->password);
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $email
                ));
        }
        
        return $row;
    }
    public function getUserByEmail($email, $asArray = false)
    {
        $email = (string) $email;
        $rowset = $this->select(['email' => $email]);
        $row = $rowset->current();
        //unset($row->password);
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $email
                ));
        }
        
        return $row;
    }
    public function fetchUserById($id)
    {
        $id = (int) $id;
        $rowset = $this->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
                ));
        }
        $row->password = null;
        return $row;
    }
    public function getUser($id)
    {
        $id = (int) $id;
        $rowset = $this->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
                ));
        }
        
        return $row;
    }
    
    public function save(User $user)
    {
        //var_dump($user);
        
       // die(__FILE__);
        if($user instanceof User)
        {
            $data = $user->getArrayCopy();
        }
        $data = [
            'userName' => $user->userName,
            'email' => $user->email,
            'password'  => $user->password,
        ];
        
        $id = (int) $user->id;
        
        if ($id === 0) {
            $this->insert($data);
            $data = new User($data);
           // parent::save($data);
            return;
        }
        
        try {
            $data = $this->getUser($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update User with identifier %d; does not exist',
                $id
                ));
        }
        
        $result = $this->update($data, ['id' => $id]);
        if($result > 0) {
            //$this->logger->notice("$data->firstName $data->lastName updated thier information", ['extra_userId' => $data->id]);
        }
    }
    
    public function deleteUser($id)
    {
        $this->delete(['id' => (int) $id]);
    }
}