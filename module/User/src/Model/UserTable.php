<?php
namespace User\Model;
use Application\Model\AbstractModel;
use RuntimeException;
use Laminas\Session;
use User\Model\User as User;
use Application\Model\LoggableEntity;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Validator\EmailAddress as emailValidater;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;
use Laminas\Authentication\AuthenticationService as AuthService;
use Laminas\Authentication\Result;
use Laminas\EventManager\EventManager;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerInterface;

class UserTable extends AbstractModel implements EventManagerAwareInterface
{
    protected $events;

    public function login(User $user)
    {
        
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
                                       'user', 
                                       'email', 
                                       'password',
                                       $callback);

        $authAdapter->setIdentity($user->email)
        ->setCredential($user->getPassword());
        
        $select = $authAdapter->getDbSelect();
        $select->where('active = 1')->where('verified = 1');
        
        // Perform the authentication query, saving the result
        $authService = new AuthService();
        $authService->setAdapter($authAdapter);
       //$result = $authAdapter->authenticate();
        $result = $authService->authenticate();
        //var_dump($result->getMessages());
            switch ($result->getCode()) {
                
                case Result::SUCCESS:
                    /** do stuff for successful authentication **/
                   // $omitColumns = ['password'];
                    //$userSession = new Session\Container('user');
                    //$userSession->details = $authAdapter->getResultRowObject(null, $omitColumns);
                    //var_dump($authAdapter->getResultRowObject(null, $omitColumns));
                    return true;
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
        //}
        
        //die();
    }
    public function test($userId, $message, $priority, $log)
    {
        //var_dump(__FUNCTION__);
        $params = compact('userId', 'message', 'priority');
        //$log->debug($this->events);
        $log->debug('debug message');
        $this->getEventManager()->trigger(__FUNCTION__, $this, $params);
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
    public function getUserByEmail($email, $asArray = false)
    {
        $email = (string) $email;
        $rowset = $this->tableGateway->select(['email' => $email]);
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
        $rowset = $this->tableGateway->select(['id' => $id]);
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
    
    public function save(User $user)
    {
        $log = [
            'message' => 'User',
            'extra' => [
                'userId' => $user->id,
                
            ],
        ];
        $this->getEventManager()->trigger(__FUNCTION__, $this, $log);
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
            $this->tableGateway->insert($data);
            $data = new User($data);
           // parent::save($data);
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
    /**
     * {@inheritDoc}
     * @see \Laminas\EventManager\EventManagerAwareInterface::setEventManager()
     */
    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers([
            __CLASS__,
            get_class($this),
        ]);
        $this->events = $events;
    }
    
    /**
     * {@inheritDoc}
     * @see \Laminas\EventManager\EventsCapableInterface::getEventManager()
     */
    public function getEventManager()
    {
        if (! $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }
}
?>