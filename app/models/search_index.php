<?php

  /**
   * Search Index Model
   *
   * @category Model
   * @package  OpenCamp
   * @version  1.0
   * @author   Darren Moore <darren.m@firecreek.co.uk>
   * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
   * @link     http://opencamp.firecreek.co.uk
   */
  class SearchIndex extends AppModel
  {
    /**
     * Name of model
     *
     * @access public
     * @var string
     */
    public $name = 'SearchIndex';
    
    /**
     * Behaviors
     *
     * @access public
     * @var array
     */
    public $actsAs = array(
      'Containable'
    );
    
    /**
     * Validation rules
     *
     * @access public
     * @var array
     */
    public $validate = array(
    );
    
    /**
     * Belongs to
     *
     * @access public
     * @var array
     */
    public $belongsTo = array(
      'Account' => array(
        'className' => 'Account',
        'dependent' => true
      ),
      'Project' => array(
        'className' => 'Project',
        'dependent' => true
      ),
      'Person' => array(
        'className' => 'Person',
        'dependent' => true
      )
    );

  }
  
?>
