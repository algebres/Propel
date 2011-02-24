<?php

  /**
   * Grant Model
   *
   * @category Model
   * @package  OpenCamp
   * @version  1.0
   * @author   Darren Moore <darren.m@firecreek.co.uk>
   * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
   * @link     http://opencamp.firecreek.co.uk
   */
  class Grant extends AppModel
  {
    /**
     * Model name
     *
     * @access public
     * @var string
     */
    public $name = 'Grant';
    
    /**
     * Behaviors
     *
     * @access public
     * @var array
     */
    public $actsAs = array('Containable');
    
    /**
     * Has many
     *
     * @access public
     * @var array
     */
    public $hasMany = array(
      'GrantSet'
    );
    
  }
  
?>
