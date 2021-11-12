<?php
namespace Project\Model;
use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;
use User\Filter\PasswordFilter;
use Laminas\Permissions\Acl\ProprietaryInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
class Project implements ResourceInterface, ProprietaryInterface
{
    protected $resourceId = 'project';
    public $id;
    /**
     * 
     * @var int $userId
     * Foreign Key linked to users table id column
     */
    public $userId;
    public $companyName;
    /**
     * 
     * @var int $pageId
     * Foreign Key pointing to page table to allow relating a page to a project
     */
    public $pageId;
    /**
     * 
     * @var $active
     * boolean
     */
    public $active;
    
    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->userId = !empty($data['userId']) ? $data['userId'] : null;
        $this->companyName = !empty($data['companyName']) ? $data['companyName'] : null;
        $this->active = !empty($data['active']) ? $data['active'] : null;
    }
    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'userId' => $this->userId,
            'companyName' => $this->companyName,
            'active' => $this->active,
        ];
    }
    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\Resource\ResourceInterface::getResourceId()
     */
    public function getResourceId()
    {
        // TODO Auto-generated method stub
        return $this->resourceId;
    }

    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\ProprietaryInterface::getOwnerId()
     */
    public function getOwnerId()
    {
        // TODO Auto-generated method stub
        return $this->userId;
    }

    
}