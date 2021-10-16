<?php
namespace Album\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\Plugin\Layout;

class AlbumController extends AbstractActionController
{
    public function indexAction()
    {
        $layout = new Layout();
        
        var_dump($layout);
    }
    
    public function addAction()
    {
    }
    
    public function editAction()
    {
    }
    
    public function deleteAction()
    {
    }
}