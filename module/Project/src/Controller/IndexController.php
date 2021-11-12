<?php
namespace Project\Controller;
use Application\Controller\AbstractController;
use Project\Model\ProjectTable;

class IndexController extends AbstractController
{
    public $table;
    
    // Add this constructor:
    public function __construct(ProjectTable $table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {
        //var_dump($this->table->fetchAll());
        $result = $this->table->fetchAll();
        foreach($result as $project) {
            var_dump($project->getResourceId());
        }
    }
    public function editAction()
    {
        $projectId = (int) $this->params()->fromRoute();
        var_dump($this->user);
        $project = $this->table->fetchById($projectId);
        var_dump($project);

        switch ($this->acl->isAllowed($this->user, $project, $this->params()->fromRoute('action'))) {
            case true:
                die('allowed');
                break;
            default:
                die('not allowed');
                break;
        }
    }
}