<?php
namespace Album\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\Plugin\Layout;
use Album\Model\AlbumTable;
use Album\Model\Album;

class AlbumController extends AbstractActionController
{
    // Add this property:
    private $table;
    
    // Add this constructor:
    public function __construct(AlbumTable $table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {
        //$layout = new Layout();
        //$view = new ViewModel();
        
            $view = new ViewModel([
                'albums' => $this->table->fetchAll(),
            ]);
        
       
            $data = array('key' => 'value', 'key_two' => 'value two');
            $child = new ViewModel(['data' => $data]);
            $child->setTemplate('Album/Album/custom');
            
            $view->addChild($child, 'child_template');
           // var_dump($view);
            return $view;
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