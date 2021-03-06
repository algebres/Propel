<?php
  $javascript->link('listable.js', false);
  $javascript->link('todos_list.js', false);
  $javascript->link('todos_add.js', false);
  $html->css('todos', null, array('inline'=>false));
?>


<div id="TodoAdd" style="display:none;">
  <?php
    echo $this->element('todos/add');
  ?>
</div>


<div id="TodoList">

  <div class="cols">

    <div class="col left">

      <div id="TodoList">
        <div class="box">
          <div class="banner">
            <h2><?php __('To-do lists'); ?></h2>
            <?php echo $this->element('todos/banner_filters'); ?>
          </div>
          <div class="content">
            <?php if(!empty($todos)): ?>
            
              <?php
                  echo $this->element('todos/list',array(
                    'records' => $todos,
                    'showCount' => true
                  ));
                  
                echo $javascript->codeBlock("
                  $('.listable').listable({
                    sortable:true,
                    positionUrl:'".$html->url(array('controller'=>'todos_items','action'=>'update_positions'))."'
                  });
                ");
              ?>
              
            <?php else: ?>
          
          
              <?php if(isset($responsibleName) && isset($dueName)): ?>
                
                  <strong><?php echo $responsibleName; ?></strong>
                  <?php __('isn\'t responsible for any to-do items'); ?>
                  <strong><?php __('due'); ?> <?php echo $dueName; ?></strong>
                
              <?php elseif(isset($responsibleName)): ?>
              
                  <strong><?php echo $responsibleName; ?></strong> <?php __('isn\'t responsible for any to-do items'); ?>
                
              <?php elseif(isset($dueName)): ?>
              
                  <?php __('There are no to-do items'); ?><strong> <?php __('due'); ?> <?php echo $dueName; ?></strong>

              <?php else: ?>
              
                <div class="completed-list">
                  <p><?php __('All the to-do lists in this project are completed.'); ?></p>
                  
                  <ul>
                    <?php foreach($todosCompleted as $todo): ?>
                      <li><?php echo $html->link($todo['Todo']['name'],array('action'=>'view',$todo['Todo']['id']),array('class'=>'strike')); ?></li>
                    <?php endforeach; ?>
                  </ul>
                  
                  <p class="note"><span><?php __('Hint'); ?>:</span> <?php __('You can always find your completed to-do lists in the right sidebar'); ?></p>
                </div>
              
              <?php endif; ?>
            
            <?php endif; ?>
          </div>
        </div>
      </div>

    </div>
    <div class="col right">

      <?php
        if($auth->check(array('action'=>'add')))
        {
          echo $layout->button(__('New to-do list',true),array('controller'=>'todos','action'=>'add'),'large add');
        }
        echo $this->element('todos/list_active');
        echo $this->element('todos/list_completed');
      ?>  
    
    </div>
    
  </div>
</div>
