<?php
namespace User\Model;

use RuntimeException;
use Laminas\Session;
use User\Model\User as User;
use User\Model\Profile as Profile;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;
use Laminas\Authentication\AuthenticationService as AuthService;
use Laminas\Authentication\Result;
use Laminas\Db\Sql\Select as Select;
use Laminas\Db\Metadata\Metadata;
use Laminas\Db\RowGateway\RowGatewayInterface;

class UserTable extends TableGateway
{
    protected $pk = 'id';
    public function login(RowGatewayInterface $user)
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
            $result = $authService->authenticate();
            /**
             * Handle the authentication query result
             */
            //var_dump($result->getMessages());
           // die(__FILE__);
            switch ($result->getCode()) {
                
                case Result::SUCCESS:
                    //$this->logger->info('User ' . $result->userName . ' logged in.', ['userId' => $result->id, 'userName' => $result->userName]);
                    /** do stuff for successful authentication **/
                    $omitColumns = ['password'];
                    $user = $authAdapter->getResultRowObject(null, $omitColumns);
                    
                    return $this->fetchByColumn('email', $result->getIdentity());
                    break;
                    
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    /** do stuff for nonexistent identity **/
                    return $result;
                    break;
                    
                case Result::FAILURE_CREDENTIAL_INVALID:
                    /** do stuff for invalid credential **/
                    break;
                    
                default:
                    /** do stuff for other failure **/
                    return false;
                    break;
            }
        } catch (RuntimeException $e) {
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
        
        return $row;
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
    
    protected function filterColumns($data) {
        if($data instanceof User) {
            $data = $data->toArray();
        }
        $metaData = new Metadata($this->getAdapter());
        $table = $metaData->getTable($this->table);
        $columns = $table->getColumns();
        //var_dump($allowed);
        $filtered = [];
        foreach ($columns as $allowed) {
            $column = $allowed->getName();
            if(array_key_exists($column, $data)) {
                $filtered[$column] = $data[$column];
            }
        }
        return $filtered;
    }
    public function save($data, $new = true)
    {
        try {
            if($data instanceof User) {
                $data = $data->toArray();
                $data = $this->filterColumns($data);
            }
            elseif(is_array($data) && !empty($data)) {
                $data = $this->filterColumns($data);
            }
            //var_dump($data);
            $user = new User($this->pk, $this->table, $this->getAdapter());
            $user->populate($data);
            return $user->save();
            
        } catch (RuntimeException $e) {
        }
    }
    
    public function deleteUser($id)
    {
        $this->delete(['id' => (int) $id]);
    }
}