<?php

  /**
   * Comments Controller
   *
   * @category Controller
   * @package  OpenCamp
   * @version  1.0
   * @author   Darren Moore <darren.m@firecreek.co.uk>
   * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
   * @link     http://opencamp.firecreek.co.uk
   */
  class CommentsController extends AppController
  {
    /**
     * Helpers
     *
     * @access public
     * @access public
     */
    public $helpers = array('Listable');
    
    /**
     * Components
     *
     * @access public
     * @access public
     */
    public $components = array();
    
    /**
     * Uses
     *
     * @access public
     * @access public
     */
    public $uses = array('Comment');
    
    
    /**
     * Before filter
     *
     * @access public
     * @return void
     */
    public function beforeFilter()
    {
      $this->associatedController = Inflector::pluralize(Inflector::classify($this->params['associatedController']));
      $this->modelAlias = Inflector::classify($this->params['associatedController']);
      
      $this->loadModel($this->modelAlias);
      
      $this->Comment->associatedAlias = $this->modelAlias;
      
      $this->params['prefix'] = 'project';
      
      parent::beforeFilter();
    }
    
    
    /**
     * Before render
     *
     * @access public
     * @return void
     */
    public function beforeRender()
    {
      $this->set('associatedController',$this->associatedController);
      $this->set('modelAlias',$this->modelAlias);
      
      
      parent::beforeRender();
    }
    
    

    /**
     * Comments list
     * 
     * @access public
     * @return void
     */
    public function index($id)
    {
      //Add comment
      if(!empty($this->data))
      {
        $this->data['Comment']['model'] = $this->modelAlias;
        $this->data['Comment']['foreign_id'] = $id;
        $this->data['Comment']['person_id'] = $this->Authorization->read('Person.id');
        
        $this->Comment->set($this->data);
        
        if($this->Comment->validates())
        {
          if($this->Comment->save())
          {
            //Add self to subscribers
            $this->Comment->addCommentPerson($this->Authorization->read('Person.id'));
            
            //Add checked
            /*if(isset($data['CommentPeople']['person_id']) && !empty($data['CommentPeople']['person_id']))
            {
              foreach($data['CommentPeople']['person_id'] as $personId)
              {
                $this->addCommentPerson($model, $personId);
              }
            }*/
            
            //Update count
            $this->Comment->updateCommentCount($id);
          }
        }
        
      }
      
      //Load
      $record = $this->{$this->modelAlias}->find('first',array(
        'conditions' => array($this->modelAlias.'.id'=>$id),
        'contain' => array(
          'Responsible' => array(),
          'Comment' => array('Person'),
          'CommentPerson' => array(
            'Person' => array(
              'fields' => array('id','full_name','email','user_id','company_id'),
              'Company' => array('id','name')
            )
          )
        )
      ));
      
      $this->set(compact('id','record'));
    }
    
    

    /**
     * Delete comment
     * 
     * @access public
     * @return void
     */
    public function delete($id,$commentId)
    {
      $this->Comment->id = $commentId;
    
      if($this->Comment->isOwner())
      {
        $this->Comment->recursive = -1;
        $this->Comment->delete($commentId);
        $this->Session->setFlash(__('Comment deleted',true),'default',array('class'=>'success'));
      }
      else
      {
        $this->Session->setFlash(__('Failed to delete Comment record',true),'default',array('class'=>'error'));
      }
      
      $this->redirect($this->referer());
    }
    
  
  }
  
  
?>
