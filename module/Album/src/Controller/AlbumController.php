<?php
namespace Album\Controller;

;use Laminas\Mvc\Controller\AbstractActionController;
use Application\Controller\AbstractController;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\Plugin\Layout;
use Album\Model\AlbumTable;
use Album\Model\Album;
use Album\Form\AlbumForm;


class AlbumController extends AbstractController
{
    // Add this property:
    //public $table;
    
    // Add this constructor:
    public function __construct(AlbumTable $table)
    {
        $this->table = $table;
        
    }
    public function _init()
    {
        $this->table->setAcl($this->acl);
    }

    public function indexAction()
    {
        // $layout = new Layout();
        // $view = new ViewModel();
        // var_dump($this->table->getResourceId());
        // var_dump($this->table->getAcl());
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');
        
        // $view = new ViewModel([
        // 'albums' => $this->table->fetchAll(),
        // ]);
        $this->view->setVariable('albums', $this->table->fetchAll());
        $child = new ViewModel([
            'form' => $form
        ]);
        $child->setTemplate('Album/Album/form');
        
        $this->view->addChild($child, 'form_template');
        // var_dump($view);
        return $this->view;
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
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if (0 === $id) {
            return $this->redirect()->toRoute('album', ['action' => 'add']);
        }
        
        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $album = $this->table->getAlbum($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }
        
        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];
        
        if (! $request->isPost()) {
            return $viewData;
        }
        
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());
        
        if (! $form->isValid()) {
            return $viewData;
        }
        
        try {
            $this->table->saveAlbum($album);
        } catch (\Exception $e) {
        }
        
        // Redirect to album list
        return $this->redirect()->toRoute('album', ['action' => 'index']);
    }
    
    public function deleteAction()
    {
    }
}