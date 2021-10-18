<?php
namespace Album\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\Plugin\Layout;
use Album\Model\AlbumTable;
use Album\Model\Album;
use Album\Form\AlbumForm;


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
        
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');
        
            $view = new ViewModel([
                'albums' => $this->table->fetchAll(),
            ]);
        
            $child = new ViewModel(['form' => $form]);
            $child->setTemplate('Album/Album/form');
            
            $view->addChild($child, 'form_template');
           // var_dump($view);
            return $view;
    }
    
    public function addAction()
    {
        
        //var_dump($data);
//         $post = new Album([]);
//         $post->id = $data['id'];
//         $post->artist = $data['artist'];
//         $post->title = $data['title'];
//         var_dump($post);
//         $this->table->saveAlbum($post);

        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');
        
        $request = $this->getRequest();
        
        if (! $request->isPost()) {
            return ['form' => $form];
        }
        
        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());
        
        if (! $form->isValid()) {
            return ['form' => $form];
        }
        
        $album->exchangeArray($form->getData());
        $this->table->saveAlbum($album);
        return $this->redirect()->toRoute('album');
        
    }
    
    public function editAction()
    {

    }
    
    public function deleteAction()
    {
    }
}