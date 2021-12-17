<?php
namespace Application\Model;
use RuntimeException;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Permissions\Acl\ProprietaryInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
//use Laminas\Permissions\Acl\Role\RoleInterface;
use Laminas\Db\RowGateway\RowGateway;
use Laminas\Db\Metadata\Metadata;

abstract class AbstractPrototype implements ResourceInterface, ProprietaryInterface
{
    #################################################
    ## Class properties will change to constants   ##
    ## when supported Php moves to 8.1.0           ##
    #################################################
    /**
     * 
     * @var $resoureId string Used by Acl ResourceInterface to 
     * represent the resource to the Acl query
     */
    protected $resourceId;
    /**
     * 
     * @var $ownerId will hold the foreignkey
     * that links this row to the user table id 
     * of the owner used by Acl ProprietaryInterface
     * to represent the owner during the Acl query
     */
    protected $ownerId;
    protected $dbAdapter;
    /**
     * 
     * @var array $columns 
     */
    protected $columns = [];
    protected $tableObject;
    /**
     * 
     * @var $tableName string naming the table for 
     * which the concrete implementations will serve as a prototype
     */
    protected $tableName;

    /**
     * 
     * @var $metaData Metadata
     */
    protected $metaData;
    /**
     * 
     * @var $pk string Primary Key for this row
     */
    protected $pk;
    /**
     * 
     * @var $row RowGateway
     */
    public $row;
    
    public function __construct(AdapterInterface $dbAdapter, array $rowData = [])
    {
        try {
            if($dbAdapter instanceof AdapterInterface) {
                $this->dbAdapter = $dbAdapter;
                $this->metaData = new Metadata($this->dbAdapter);
                $this->tableObject = $this->metaData->getTable($this->tableName);
                $columns = $this->tableObject->getColumns();
                foreach ($columns as $column) {
                    $columnName = $column->getName();
                    $this->columns[$columnName] = null;
                }
            }
            $this->row = new RowGateway($this->pk, $this->tableName, $this->dbAdapter);
            if(!empty($rowData)) {
                $this->populate($rowData, false);
            }
        } catch (RuntimeException $e) {
            
        }
    }
    public function __get($name)
    {
        return $this->row->{$name};
    }
    public function __set($name, $value)
    {
        //Check the returned meta data for the table and filter assigned properties to only allow current columns
        if(array_key_exists($name, $this->columns)) {
            $this->row->{$name} = $value;
        }
    }
    public function exchangeArray($data)
    {
        if( empty($data[$this->pk]) || isset($data[$this->pk]) && $data[$this->pk] === 0 || $data[$this->pk] === '0')
        {   
            $this->populate($data);
        }
        elseif(!empty($data[$this->pk]) && isset($data[$this->pk]) && (int) $data[$this->pk] > 0)
        {
            //var_dump($this->row);
           // die(__FILE__.'::'.__LINE__);
            $this->populate($data, true);
        }
        
    }
    public function __call($method, $args)
    {
        switch($method){
            case 'populate' :
                // Proxy to Rowgateway::populate(array $data, existingRow flag
                if(is_array($args[0]) && !empty($args[0])) {
                    if(isset($args[0][$this->pk]) && $args[0][$this->pk] === 0 || $args[0][$this->pk] === '0') {
                        $args[0][$this->pk] = null;
                    }
                    $data = [];
                    foreach($this->columns as $columnName => $columnValue) {
                        if(array_key_exists($columnName, $args[0])) {
                            $data[$columnName] = $args[0][$columnName];
                        }
                    }
                    
                    // does this row already exists in the table? if so we have to pass this flag
                    if(isset($args[1]) && $args[1] === true) {
                        $this->row->{$method}($data, $args[1]);
                    }
                    else {
                        $this->row->{$method}($data);
                    }
                }
                return $this;
                break;
            default:
                if(!empty($args)) {
                    return $this->row->{$method}($args);
                }
                return $this->row->{$method}();
                break;
        }       
    }
    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\ProprietaryInterface::getOwnerId()
     */
    public function getOwnerId()
    {
        // TODO Auto-generated method stub
        return $this->ownerId;
    }
    
    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\Role\RoleInterface::getRoleId()
     */
    public function getRoleId()
    {
        // TODO Auto-generated method stub
        return $this->role;
    }
    public function getResourceId()
    {
        return $this->resourceId;
    }
    // Add the following method:
    public function getArrayCopy()
    {
        return $this->row->toArray();
    }
    /**
     * @return the $dbAdapter
     */
    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }
    /**
     * @param field_type $dbAdapter
     */
    public function setDbAdapter($dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
}