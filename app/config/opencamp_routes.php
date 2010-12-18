<?php

  // Installer
  if(!file_exists(CONFIGS.'settings.php'))
  {
    Router::connect('/', array('plugin' => 'install' ,'controller' => 'install'));
    return;
  }

  Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
  Router::connect('/users/login', array('controller' => 'users', 'action' => 'login'));
  Router::connect('/users/logout', array('controller' => 'users', 'action' => 'logout'));
  Router::connect('/users/register', array('controller' => 'users', 'action' => 'register'));
  
  
  //Projects
  Router::connect('/:accountSlug/:projectId',
    array('controller'=>'projects', 'action'=>'index', 'prefix'=>'project'),
    array('accountSlug'=>'[a-z0-9\-]+','projectId'=>'[0-9]+')
  );
  Router::connect('/:accountSlug/:projectId/:controller/:action/*',
    array('controller'=>'projects', 'action'=>'index', 'prefix'=>'project'),
    array('accountSlug'=>'[a-z0-9\-]+','projectId'=>'[0-9]+')
  );
  
  
  //Accounts
  Router::connect('/:accountSlug',
    array('controller'=>'accounts', 'action'=>'index', 'prefix'=>'account'),
    array('accountSlug'=>'[a-z0-9\-]+')
  );
  Router::connect('/:accountSlug/:controller/:action/*',
    array('controller'=>'accounts', 'action'=>'index', 'prefix'=>'account'),
    array('accountSlug'=>'[a-z0-9\-]+')
  );

?>