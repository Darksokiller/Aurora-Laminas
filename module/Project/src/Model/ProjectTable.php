<?php
namespace Project\Model;
use Laminas\Authentication\Adapter\DbTable\Exception\RuntimeException as RuntimeException;
use Application\Model\AbstractModel;

class ProjectTable extends AbstractModel
{
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    public function fetchById($id) {
        $result = $this->tableGateway->select(['id' => $id]);
        $row = $result->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
                ));
        }
        return $row;
    }
}

