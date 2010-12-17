<?php

  /**
   * Users Controller
   *
   * @category Controller
   * @package  OpenCamp
   * @version  1.0
   * @author   Darren Moore <darren.m@firecreek.co.uk>
   * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
   * @link     http://opencamp.firecreek.co.uk
   */
  class UsersController extends AppController
  {
    /**
     * Helpers
     *
     * @access public
     * @access public
     */
    public $helpers = array();
    
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
    public $uses = array('User');
    
    
    /**
     * Register new user, account and person
     *
     * @access public
     * @return void
     */
    public function register()
    {
      if(!empty($this->data))
      {
        $this->User->saveAll($this->data, array('validate' => 'only'));
        
        if($this->User->validates())
        {
          //Account
          $this->data['Account']['slug'] = $this->User->Account->makeSlug($this->data['Company']['name']);
        
          $saved = $this->User->saveAll($this->data, array('validate'=>false));
          
          if($saved)
          {
            //@todo Fix up, some association id's are not being set after save
            $this->User->Company->saveField('account_id',$this->User->Account->id);
            $this->User->Company->saveField('person_id',$this->User->Person->id);
            $this->User->Person->saveField('company_id',$this->User->Company->id);
            $this->User->Person->saveField('user_id',$this->User->id);
            $this->User->Account->saveField('person_id',$this->User->Person->id);
            $this->User->Account->saveField('user_id',$this->User->id);
            $this->User->Account->saveField('company_id',$this->User->Company->id);
            
            $this->Authorization->login($this->data);
            
            $this->redirect(array(
              'controller'  => 'accounts',
              'action'      => 'index',
              'prefix'      => 'account',
              'account'     => $this->data['Account']['slug']
            ));

          }
          else
          {
            $this->Session->setFlash(__('Error creating user, try again', true), 'default', array('class' => 'error'));
          }
        }
        else
        {
          //Failed validation
          $this->data['User']['password'] = null;
          $this->data['User']['password_confirm'] = null;
        }
      }
    }
    
    
    /**
     * Login
     *
     * @access public
     * @return void
     */
    public function login()
    {
    }
    
    
    /**
     * Logout
     *
     * @access public
     * @return void
     */
    public function logout()
    {
    }
    
    
    /**
     * Forgotten password reminder
     *
     * @access public
     * @return void
     */
    public function forgotten()
    {
    }
  
  }
  
  
?>