<?php

  /**
   * App Error
   *
   * @package  OpenCamp
   * @version  1.0
   * @author   Darren Moore <darren.m@firecreek.co.uk>
   * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
   * @link     http://opencamp.firecreek.co.uk
   */
  class AppError extends ErrorHandler
  {
    /**
     * notLoggedIn
     *
     * @access public
     * @return void
     */
    public function notLoggedIn($params)
    {
      $this->_outputMessage('not_logged_in');
    }

    /**
     * xx
     *
     * @access public
     * @return void
     */
    public function accountNotFound($params)
    {
      $this->_outputMessage('account_not_found');
    }

    /**
     * xx
     *
     * @access public
     * @return void
     */
    public function prefixNotFound($params)
    {
      $this->_outputMessage('prefix_not_found');
    }

    /**
     * xx
     *
     * @access public
     * @return void
     */
    public function personNotFound($params)
    {
      $this->_outputMessage('person_not_found');
    }

    /**
     * xx
     *
     * @access public
     * @return void
     */
    public function personNoAro($params)
    {
      $this->_outputMessage('person_no_aro');
    }

    /**
     * xx
     *
     * @access public
     * @return void
     */
    public function badCrudAccess($params)
    {
      $this->_outputMessage('bad_crud_access');
    }

    /**
     * xx
     *
     * @access public
     * @return void
     */
    public function recordNotFound($params)
    {
      $this->_outputMessage('record_not_found');
    }

    /**
     * xx
     *
     * @access public
     * @return void
     */
    public function recordWrongPrefix($params)
    {
      $this->_outputMessage('record_wrong_prefix');
    }

    /**
     * xx
     *
     * @access public
     * @return void
     */
    public function recordIsPrivate($params)
    {
      $this->_outputMessage('record_is_private');
    }

    /**
     * xx
     *
     * @access public
     * @return void
     */
    public function recordWrongAccount($params)
    {
      $this->_outputMessage('record_wrong_account');
    }

    /**
     * xx
     *
     * @access public
     * @return void
     */
    public function unknownAclError($params)
    {
      $this->_outputMessage('unknown_acl_error');
    }
    
    
    /**
     * Output message
     * 
     * This is a direct copy from cakephp core error.php
     *
     * @access private
     * @return void
     */
    public function _outputMessage($template)
    {
      $this->controller->layout = 'error';
      
      if(isset($this->controller->RequestHandler) && $this->controller->RequestHandler->isAjax())
      {
        $this->controller->layout = 'js/error';
      }
      
      $this->controller->render($template);
      $this->controller->afterFilter();
      echo $this->controller->output;
    }
  
  }

?>
