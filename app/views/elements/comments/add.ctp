
<div class="comment-add">

  <div class="section plain avatar">
    <div class="avatar"><?php echo $html->image('avatar.png'); ?></div>
    <div class="banner">
      <h4><?php __('Leave a comment...'); ?></h4>
    </div>
    <div class="content">
      <?php
        echo $form->create('Comment',array('url'=>$this->here)); 
        echo $form->input('body',array('type'=>'textarea','label'=>false));
      ?>
      
      <?php
        $people = $layout->notificationList($auth->read('People'));
        if(!empty($people)):
      ?>
        
        <h5><?php __('Subscribe people to receive email notifications'); ?></h5>
        <p>
          <?php __('The people you select will get an email when you post this comment.'); ?><br />
          <?php __('They\'ll also be notified by email every time a new comment is added.'); ?>
        </p>
        
        <?php
          echo $form->input('CommentPeople.person_id',array(
            'multiple'  => 'checkbox',
            'options'   => $people,
            'label'     => false,
            'escape'    => false,
            'legend'    => false,
            'prefixResponsible' => true
          ));
        ?>
      
      <?php
        endif;
      ?>
      
      <?php
        echo $form->submit(__('Add this comment',true));
        echo $form->end();
      ?>
    </div>
  </div>
  
</div>
