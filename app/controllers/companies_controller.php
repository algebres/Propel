<?php

  /**
   * Companies Controller
   *
   * @category Controller
   * @package  OpenCamp
   * @version  1.0
   * @author   Darren Moore <darren.m@firecreek.co.uk>
   * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
   * @link     http://opencamp.firecreek.co.uk
   */
  class CompaniesController extends AppController
  {
    /**
     * Helpers
     *
     * @access public
     * @var array
     */
    public $helpers = array();
    
    /**
     * Components
     *
     * @access public
     * @var array
     */
    public $components = array();
    
    /**
     * Uses
     *
     * @access public
     * @var array
     */
    public $uses = array('Company');
    
    /**
     * Action map
     *
     * @access public
     * @var array
     */
    public $actionMap = array(
      'permissions'  => '_update',
    );
    
    
    /**
     * Index
     *
     * @access public
     * @return void
     */
    public function account_index()
    {
      $records = $this->_people();
      $this->set(compact('records'));
    }
    
    
    /**
     * Add
     *
     * @access public
     * @return void
     */
    public function account_add()
    {
      if(!empty($this->data))
      {
        $this->data['Company']['account_id'] = $this->Authorization->read('Account.id');
        $this->data['Company']['person_id'] = $this->Authorization->read('Person.id');
      
        $this->Company->set($this->data);
        
        if($this->Company->validates())
        {
          if($this->Company->save($this->data))
          {
            //Grant permission for company
            $this->AclManager->allow($this->Company, 'accounts', $this->Authorization->read('Account.id'), array('set' => 'company'));
            
            //Redirect
            $this->Session->setFlash(__('Company created',true), 'default', array('class'=>'success'));
            $this->redirect(array('controller'=>'companies','action'=>'index'));
          }
          else
          {
            $this->Session->setFlash(__('Failed to save company',true), 'default', array('class'=>'error'));
          }
        }
        else
        {
          $this->Session->setFlash(__('Please check the form and try again',true), 'default', array('class'=>'error'));
        }
      }
    }
    
    
    /**
     * Edit
     *
     * @access public
     * @return void
     */
    public function account_edit($companyId)
    {
      $record = $this->Company->find('first',array(
        'conditions' => array(
          'Company.id' => $companyId,
          'Company.account_id' => $this->Authorization->read('Account.id')
        ),
        'contain' => array()
      ));
      
      if(empty($record))
      {
        $this->Session->setFlash(__('You do not have permission to access this company',true),'default',array('class'=>'error'));
        $this->redirect($this->referer(), null, true); 
      }
      
      //Save
      if(!empty($this->data))
      {
        $this->data['Company']['id'] = $companyId;
        
        $this->Company->set($this->data);
        
        if($this->Company->validates())
        {
          $this->Company->save();
          $this->Session->setFlash(__('Company details updated',true));
          $this->redirect(array('action'=>'index'));
        }
        else
        {
          $this->Session->setFlash(__('Please check the form and try again',true),'default',array('class'=>'error'));
        }
      }
      
      $countries = $this->Company->Country->find('list');
      
      if(empty($this->data))
      {
        $this->data = $record;
      }
      
      $this->set(compact('companyId','countries','record'));
    }
    
    
    /**
     * Delete
     *
     * @access public
     * @return void
     */
    public function account_delete($companyId)
    {
      $record = $this->Company->find('first',array(
        'conditions' => array(
          'Company.id' => $companyId,
          'Company.account_id' => $this->Authorization->read('Account.id'),
          'Company.account_owner' => false
        ),
        'contain' => false
      ));
      
      if(empty($record))
      {
        $this->Session->setFlash(__('You do not have permission to delete this company',true),'default',array('class'=>'error'));
        $this->redirect($this->referer(), null, true); 
      }
      

      //Delete permission for company
      $this->Company->id = $companyId;
      $this->AclManager->delete($this->Company, 'accounts', $this->Authorization->read('Account.id'), array('set' => 'company'));
      
      //Delete company
      $this->Company->delete($companyId);
      
      //Redirect
      $this->Session->setFlash(__('This company has been deleted',true),'default',array('class'=>'success'));
      $this->redirect(array('action'=>'index'));
    }
    
    
    /**
     * Project index
     *
     * @access public
     * @return void
     */
    public function project_index()
    {
      $records = $this->_people();
      $this->set(compact('records'));
    }
    
    
    /**
     * Project permissions
     *
     * @access public
     * @return void
     */
    public function project_permissions()
    {
      $records = $this->_people();
      $this->set(compact('records'));
    }
    
    
    /**
     * Project add company
     *
     * @access public
     * @return void
     */
    public function project_add()
    {
      //Get list of companies that can be added
      $modelRootNode = $this->Acl->Aco->node('opencamp/accounts/'.$this->Authorization->read('Account.id'));
      $records = $this->Acl->Aco->Permission->find('all', array(
        'conditions' => array(
          'Aro.model' => 'Company',
          'Permission.aco_id' => $modelRootNode[0]['Aco']['id'],
          'Permission._read' => true
        ),
        'fields' => array('Aro.foreign_key')
      ));
      $records = Set::extract($records,'{n}.Aro.foreign_key');
      
      //Remove records that have already been added
      $existingCompanies = $this->Authorization->read('Companies');
      
      foreach($existingCompanies as $existingCompany)
      {
        $find = array_search($existingCompany['Company']['id'],$records);
        
        if($find !== false)
        {
          unset($records[$find]);
        }
      }
      
      //List of companies that can be added
      $companies = $this->User->Company->find('list',array(
        'conditions' => array(
          'Company.id' => $records
        ),
        'fields' => array('id','name'),
        'contain' => false
      ));
    
      //Post
      if(!empty($this->data))
      {
        if(isset($this->data['Company']['id']) && is_numeric($this->data['Company']['id']))
        {
          //Checks
          if(isset($companies[$this->data['Company']['id']]))
          {
            //Grant permission for company to project
            $this->Company->id = $this->data['Company']['id'];
            $this->AclManager->allow($this->Company, 'projects', $this->Authorization->read('Project.id'), array('set' => 'company'));
            
            $this->Session->setFlash(__('Company added to project',true), 'default', array('class'=>'success'));
          }
          else
          {
            $this->Session->setFlash(__('You do not have permission to add the company',true), 'default', array('class'=>'error'));
          }
          
          $this->redirect(array('controller'=>'companies','action'=>'index'));
        }
        else
        {
          //Normal save
          $this->data['Company']['account_id'] = $this->Authorization->read('Account.id');
          $this->data['Company']['person_id'] = $this->Authorization->read('Person.id');
        
          $this->Company->set($this->data);
          
          if($this->Company->validates())
          {
            if($this->Company->save($this->data))
            {
              //Grant permission for company to account
              $this->AclManager->allow($this->Company, 'accounts', $this->Authorization->read('Account.id'), array('set' => 'company'));
              
              //Grant permission for company to project
              $this->AclManager->allow($this->Company, 'projects', $this->Authorization->read('Project.id'), array('set' => 'company'));
              
              //Redirect
              $this->Session->setFlash(__('Company created',true), 'default', array('class'=>'success'));
              $this->redirect(array('controller'=>'companies','action'=>'index'));
            }
            else
            {
              $this->Session->setFlash(__('Failed to save company',true), 'default', array('class'=>'error'));
            }
          }
          else
          {
            $this->Session->setFlash(__('Please check the form and try again',true), 'default', array('class'=>'error'));
          }
        }
      }
      
      $this->set(compact('companies'));
    }
    
    
    /**
     * Project delete company
     *
     * This function does not delete companies, it will only remove the
     * company and people from permissions
     * 
     * @access public
     * @return void
     */
    public function project_delete($id)
    {
      //Delete permission for company
      $this->Company->id = $id;
      $this->AclManager->delete($this->Company, 'projects', $this->Authorization->read('Project.id'), array('set' => 'company'));
      
      $this->Session->setFlash(__('Company has been removed from this project',true),'default',array('class'=>'success'));
      $this->redirect(array('action'=>'permissions'));
    }
    
    
    /**
     * Map companies and people
     *
     * @access public
     * @return void
     */
    private function _people()
    {
      $companies = $this->Authorization->read('Companies');
      $people = $this->Authorization->read('People');
      
      $mapped = array();
  
      foreach($companies as $key => $company)
      {
        $companies[$key]['People'] = array();
        
        foreach($people as $person)
        {
          if($person['Company']['id'] == $company['Company']['id'])
          {
            $companies[$key]['People'][] = $person['Person'];
            continue;
          }
        }
      }
      
      return $companies;
    }
    
  
  }
  
  
?>
