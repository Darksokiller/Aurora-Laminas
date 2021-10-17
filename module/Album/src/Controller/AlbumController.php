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
        $data = array('id' => 0,
                      'title' => 'Love the way you lie',
                      'artist' => 'Eminem'
        );
        //var_dump($data);
        $post = new Album([]);
        $post->id = $data['id'];
        $post->artist = $data['artist'];
        $post->title = $data['title'];
        var_dump($post);
        $this->table->saveAlbum($post);
    }
    
    public function editAction()
    {
        $data = array('id' => 0,
            'title' => 'Love the way you lie',
            'artist' => 'Eminemmmmm'
        );
        //var_dump($data);
        $post = new Album([]);
        $post->id = 3;
        $post->artist = $data['artist'];
        $post->title = $data['title'];
        var_dump($post);
        $this->table->saveAlbum($post);
    }
    
    public function deleteAction()
    {
    }
}