<?php
  $this->set('activeMenu','companies');
  
  //My account?
  $personal = false;
  if($personId == $session->read('Auth.Person.id'))
  {
    $personal = true;
  }

?>
<div class="cols" id="PersonEdit">

  <div class="col left">

    <div class="box">
      <div class="banner">
        <?php if(!$personal): ?>
        
          <h2><?php __('Edit'); ?> <?php echo $record['Person']['full_name']; ?></h2>
        
        <?php else: ?>
        
          <div class="personal-banner">
            <h2><?php echo $html->link(__('Edit your personal information',true),array('project'=>false,'controller'=>'users','action'=>'edit'),array('class'=>'strong')); ?></h2>
            <p><?php __('Change your name, photo, email address, username or password.'); ?></p>  
          </div>
          
        <?php endif; ?>
      
      </div>
      <div class="content">
      
        <?php if($personal): ?>
          <h3><?php echo __('Your contact information for this account',true); ?></h3>
        <?php endif; ?>
      
        <?php if($record['Person']['status'] == 'invited'): ?>
          <div class="section outlined invite">
            <div class="banner transparent">
              <h3><?php echo sprintf(__('Can I resend %s\'s welcome invitation email?',true),$record['Person']['first_name']); ?></h3>
            </div>
            <div class="content">
              <p><?php
                $inviteLink = $html->link(__('re-send the email invitation',true),array('project'=>false,'controller'=>'people','action'=>'invite_resend',$personId));
                $inviteSent = date('F j, Y',strtotime($record['Person']['invitation_date']));
                echo sprintf(__('Yes. You can %s if it went to the wrong email address or %s didn\'t receive it. The last invitation was sent on %s.',true),$inviteLink,$record['Person']['first_name'],$inviteSent);
              ?></p>
            </div>
          </div>
        <?php endif; ?>
      
      
        <?php
          echo $form->create('Person',array('url'=>$this->here,'class'=>'basic'));
        ?>
        
      
        <?php
          
          if(!$personal)
          {
            echo $form->input('company_id',array('label'=>__('Company',true)));
          }
        
          echo $form->input('email',array('label'=>__('Email',true)));
          echo $form->input('title');
          echo $form->input('phone_number_office',array('label'=>__('Office',true).' #'));
          echo $form->input('phone_number_mobile',array('label'=>__('Mobile',true).' #'));
          echo $form->input('phone_number_fax',array('label'=>__('Fax',true).' #'));
          echo $form->input('phone_number_home',array('label'=>__('Home',true).' #'));
        ?>
      
        <hr />

        <?php
          echo $form->submit(__('Save changes',true),array('after'=>__('or',true).' '.$html->link(__('Cancel',true),array('controller'=>'companies','action'=>'index') ) ));
          
          echo $form->end();
        ?>
      </div>
    </div>

  </div>
  
  <div class="col right">
  
    <?php if(!$personal): ?>
      
      <div class="box">
        <div class="banner">
          <h3><?php __('Delete this person?'); ?></h3>
        </div>
        <div class="content">
          <p><?php __(sprintf('This will permanently remove %s from your account. Don\'t worry, their messages, comments, and history will not be erased.',$record['Person']['first_name'])); ?></p>
          <p><?php
            echo $html->link(sprintf(__('Delete %s now',true),$record['Person']['first_name']),array('project'=>false,'action'=>'delete',$personId),array('class'=>'important','confirm'=>__('Are you sure you want to delete this person?',true)));
          ?></p>
        </div>
      </div>
      
      
      <?php if(!empty($projects)): ?>
        <div class="box">
          <div class="banner">
            <h3><?php echo $record['Person']['first_name'].' '.__('can access...', true); ?></h3>
          </div>
          <div class="content">
            <?php
              echo $form->create('Permission',array('url'=>$this->here,'class'=>'block'));
            ?>
            <?php
              foreach($projects as $project)
              {
                $checked = $project['Project']['_access'] ? true : false;
                echo $form->input('Permission.'.$project['Project']['id'],array('label'=>$project['Project']['name'],'type'=>'checkbox','checked'=>$checked));
              }
            ?>
            <?php
              echo $form->submit(__('Update Project Access',true),array('after'=>__('or',true).' '.$html->link(__('Cancel',true),$this->here ) ));
            ?>
          </div>
        </div>
      <?php endif; ?>
      
    <?php endif; ?>    
      
  </div>
  
</div>
