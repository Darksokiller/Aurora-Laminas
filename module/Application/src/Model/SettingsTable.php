<?php
namespace Application\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGateway;
use Application\Permissions\PermissionsManager as Acl;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Laminas\Db\Sql\Select;

class SettingsTable 
{
    const RESOURCE_ID = 'settings';
    const SETTINGS_NAMESPACE = 'aurora';
    protected $tableGateway;
    public $acl;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    public function fetchForBootstrap()
    {
        $data = [];
        $rowset = $this->tableGateway->select();
        foreach ($rowset as $row){
            $data[SETTINGS_NAMESPACE]["$row->variable"] = $row->value;
        }
        return $data;
    }
    public function fetchAll()
    {
         $data = [];
         $rowset = $this->tableGateway->select();
         foreach ($rowset as $row){
             $data["$row->variable"] = $row->value;
         }
         return $data;
    }
    public function fetchSettingsForForm()
    {
        $data = [];
        $rowset = $this->tableGateway->select(function(Select $select){
            $select->order(['settingType']);
        });
        foreach($rowset as $row) {
            $data[] = $row->toArray();
        }
        return $data;
    }
    public function fetchSetting($variable)
    {
        $variable = (string) $variable;
        $rowset = $this->tableGateway->select(['variable' => $variable]);
        $row = $rowset->current();
        //unset($row->password);
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $variable
                ));
        }
        
        return $row;
    }
    public function save(array $settings)
    {
        try {
            if (is_array($settings)) {
                $rowset = $this->tableGateway->select();
                foreach ($rowset as $row) {
                    if (array_key_exists($row->variable, $settings)) {
                        $row->value = $settings[$row->variable];
                        $return = $row->save();
                    }
                    else {
                        // this should be a new setting
                        foreach($settings as $variable => $value) {
                            $row->variable = $variable;
                            $row->value = $value;
                            $return = $row->save();
                        }
                    }
                }
                if ($return) {
                    return $return;
                } else {
                    throw new \RuntimeException('Settings could not be updated please see error log');
                }
            }
        } catch (RuntimeException $e) {
            return $e->getMessage();
        }
    }
    public function setAcl($acl)
    {
        $this->acl = $acl;
    }
    public function getAcl()
    {
        if(empty($this->acl))
        {
            $acl = new Acl();
            $this->acl = $acl->getAcl();
        }
        return $this->acl;
    }
    public function exchangeArray()
    {
        
    }
    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\Resource\ResourceInterface::getResourceId()
     */
    public function getResourceId()
    {
        // TODO Auto-generated method stub
        return RESOURCE_ID;
    }

    
}