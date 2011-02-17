<?php

  $html->css('projects/posts', null, array('inline'=>false));
  
?>
<div class="cols">
  <div class="col left">

    <div class="box">
      <div class="banner">
        <h2><?php __('All Messages'); ?></h2>
        <?php
          $menu = array(
            'expanded'  => array('name'=>__('Expanded view',true),'url'=>array('action'=>'index','?'=>array('view'=>'expanded'))),
            'list'      => array('name'=>__('List view',true),'url'=>array('action'=>'index','?'=>array('view'=>'list')))
          );
          
          echo $layout->menu($menu,array('active'=>$viewType),array('class'=>'right'));
        ?>
      </div>
      <div class="content post-list">
        
        <?php foreach($records as $record): ?>
        
          <?php
            //Url
            $url = array('associatedController'=>'posts','controller'=>'comments','action'=>'index',$record['Post']['id']);
            
            //Comments status
            $class = null;
            
            if($record['Post']['comment_unread'] > 0)
            {
              $class = 'comments-unread';
            }
            elseif($record['Post']['comment_count'] > 0)
            {
              $class = 'comments-with';
            }
            
          ?>
          
          <?php if($viewType == 'expanded'): ?>
          
            <div class="section plain avatar <?php echo $class; ?>">
              <div class="avatar"><?php echo $html->image('avatar.png'); ?></div>
              <div class="banner">
                <p><strong><?php echo $record['Person']['full_name']; ?></strong> <?php __('posted this message'); ?> <?php echo $time->timeAgoInWords($record['Post']['created'],array('end'=>false)); ?>.</p>
                <h3><?php echo $html->link($record['Post']['title'],$url); ?></h3>
              </div>
              <div class="content">
                <p><?php echo $record['Post']['body']; ?></p>
              </div>
              <div class="foot">
                <ul>
                  <li><?php
                    echo $html->link(__('Go to message',true),$url);
                  ?></li>
                  <li><?php
                    if($record['Post']['comment_count'] == 0)
                    {
                      echo $html->link(__('Add a comment',true),$url);
                    }
                    else
                    {
                      $plural = $record['Post']['comment_count'] > 1 ? 's' : null;
                      echo $html->link($record['Post']['comment_count'].' '.sprintf(__('comment%s',true),$plural),$url);
                      echo ' <span>('.__('last by',true).' '.$record['CommentLast']['Person']['full_name'].' '.$time->timeAgoInWords($record['CommentLast']['created'],array('end'=>false)).')</span>';
                    }
                  ?></li>
                </ul>
              </div>
            </div>
          
          <?php else: ?>
          
            <div class="section list <?php echo $class; ?>">
              <div class="content">
              
                <div class="comments">
                  <?php if($record['Post']['comment_count'] > 0): ?>
                    <?php echo $html->link($record['Post']['comment_count'],$url,array('class'=>'count')); ?>
                  <?php endif; ?>
                  <?php echo $html->link('<span></span>',$url,array('class'=>'icon','escape'=>false)); ?>
                </div>
                
                <?php if($record['Post']['comment_count'] > 0): ?>
                  <p class="right last-comment"><?php echo __('Last comment by',true).' '.$record['CommentLast']['Person']['full_name'].' '.$time->timeAgoInWords($record['CommentLast']['created'],array('end'=>false)); ?></p>
                <?php endif; ?>
              
                <div class="detail">
                  <h3><?php echo $html->link($record['Post']['title'],$url); ?></h3>
                  <p>
                    <?php
                      echo __('by',true).' '.$record['Person']['full_name'].' '.__('on',true).' ';
                      echo date('D, j M Y \a\t g:ia',strtotime($record['Post']['created']));
                    ?>
                  </p>
                </div>
              </div>
            </div>
          
          <?php endif; ?>
        
        <?php endforeach; ?>
        
      </div>
    </div>
    
  </div>
  <div class="col right">
  
    <?php
      if($auth->check('Project.Posts','create'))
      {
        echo $layout->button(__('Post a new message',true),array('action'=>'add'),'large add');
      }
    ?>
    
  </div>
</div>
