<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title><?php echo $title_for_layout; ?></title>
  <?php
    echo $html->css(array(
      'style',
      'account',
      'listable'
    ));
    echo $javascript->link(array(
      'jquery/jquery',
      'jquery/jquery-ui',
      'jquery/jquery-ajaxsubmit',
      'jquery/jquery-oc-calendar',
      'jquery/jquery-oc-dialog',
      'jquery/superfish',
      'jquery/supersubs',
      'modernizr',
      'account'
    ));
    echo $scripts_for_layout;
  ?>
  <style type="text/css" media="screen"><!--
    <?php echo $this->element('style'); ?>
  --></style>
</head><?php
  //Body class
  $bodyClass = $this->name.' '.$this->action.' '.$this->params['prefix'];
?><body class="<?php echo $bodyClass; ?>">

  <div id="launchbar">
    <nav id="account">
      <?php
        //Account menu
        $projects = $auth->read('Projects');
        $projectsMenu = array();
        $projectAddText = __('Create new project',true);
        
        if(!empty($projects))
        {
          foreach($projects as $projectRecord)
          {
            $projectsMenu[] = array(
              'name' => $projectRecord['Project']['name'].' ['.$projectRecord['Company']['name'].']',
              'url' => $this->Html->url(array(
                'accountSlug' => $projectRecord['Account']['slug'],
                'projectId'   => $projectRecord['Project']['id'],
                'controller'  => 'projects',
                'action'      => 'index'
              ))
            );
          }
        }
        else
        {
          $projectAddText = __('Create your first project',true);
        }
        
        //New project
        $projectsMenu[] = array(
          'name' => $projectAddText,
          'url' => $this->Html->url(array(
            'accountSlug' => $this->Auth->read('Account.slug'),
            'project'     => false,
            'controller'  => 'projects',
            'action'      => 'add'
          ))
        );
        
        //Account menu
        $menu = array(
          'Account.accounts' => array('name'=>__('Dashboard',true),'url'=>array('account'=>true,'controller'=>'accounts','action'=>'index')),
          'Account.projects' => array('name'=>__('Projects',true),'url'=>array('account'=>true,'controller'=>'projects','action'=>'index'),'children'=>$projectsMenu),
          'Account.todos' => array('name'=>__('To-Dos',true),'url'=>array('account'=>true,'controller'=>'todos','action'=>'index')),
          'Account.milestones' => array('name'=>__('Milestones',true),'url'=>array('account'=>true,'controller'=>'milestones','action'=>'index')),
          'Account.companies' => array('name'=>__('People',true),'url'=>array('account'=>true,'controller'=>'companies','action'=>'index')),
          'Account.search' => array('name'=>__('Search',true),'url'=>array('account'=>true,'controller'=>'search','action'=>'index')),
          /*'templates' => array('name'=>__('Templates',true),'url'=>array('controller'=>'templates','action'=>'index')),*/
          'Account.settings' => array('name'=>__('Settings',true),'url'=>array('account'=>true,'controller'=>'settings','action'=>'index')),
        );
        echo $this->Layout->menu($menu,array('permissions'=>'Account'),array('class'=>'sf-menu'));
      ?>
    </nav>
    <nav id="user">
      <ul class="sf-menu">
        <li><span><?php echo $session->read('AuthAccount.Person.first_name').' '.$session->read('AuthAccount.Person.last_name'); ?></span></li>
        <li><?php echo $html->link(__('My details',true),array('controller'=>'people','action'=>'edit',$session->read('AuthAccount.Person.id'))); ?></li>
        <li><?php echo $html->link(__('Sign out',true),array('account'=>false,'controller'=>'users','action'=>'logout')); ?></li>
      </ul>
    </nav>
  </div>


  <header>
    <h1>
      <?php
        if($this->Auth->read('Project.name'))
        {
          echo $this->Auth->read('Project.name');
          echo '<span>'.$this->Auth->read('Account.name').'</span>';
        }
        else
        {
          echo $this->Auth->read('Account.name');
        }
      ?>
    </h1>
    
    <?php if($this->params['prefix'] == 'project'): ?>
      <nav class="main top tabs">
        <?php
          $menu = array(
            'Project.projects'    => array('name'=>__('Overview',true),'url'=>array('project'=>true,'controller'=>'projects','action'=>'index')),
            'Project.posts'       => array('name'=>__('Messages',true),'url'=>array('project'=>true,'controller'=>'posts','action'=>'index')),
            'Project.todos'       => array('name'=>__('To-Dos',true),'url'=>array('project'=>true,'controller'=>'todos','action'=>'index')),
            'Project.milestones'  => array('name'=>__('Milestones',true),'url'=>array('project'=>true,'controller'=>'milestones','action'=>'index')),
          );
          echo $this->Layout->menu($menu,array('permissions'=>'Project'));
        ?>
      </nav>
      <nav class="extra top tabs">
        <?php
          $menu = array(
            'Project.search'      => array('name'=>__('Search',true),'url'=>array('project'=>true,'controller'=>'search','action'=>'index')),
            'Project.companies'   => array('name'=>__('People & Permissions',true),'url'=>array('project'=>true,'controller'=>'companies','action'=>'index')),
            'Project.settings'    => array('name'=>__('Project Settings',true),'url'=>array('project'=>true,'controller'=>'projects','action'=>'edit')),
          );
          echo $this->Layout->menu($menu,array('permissions'=>'Project'));
        ?>
      </nav>
    <?php endif; ?>
  </header>


  <div id="main">
    <?php echo $session->flash(); ?>
    <?php echo $content_for_layout; ?>
  </div>
  
  <footer>
    <p><?php __('Managed with'); ?> <?php echo $html->link('Propel','http://www.propelhq.com?ref=accfoot'); ?>.</p>
  </footer>


</body>
</html>
