<?php
  $html->css('settings', null, array('inline'=>false));
?>

<div class="cols">
  <div class="col left">

    <div class="box">
      <div class="banner">
        <?php echo $this->element('settings/menu'); ?>
      </div>
      <div class="content">
      
        <?php
          echo $form->create('Account',array('url'=>$this->here,'class'=>'basic'));
        ?>
        
        <h3><?php __('Your logo'); ?></h3>
        
        <div class="logos">
        
          <div class="col account">
            <div class="image"><?php
              $imageFile = ASSETS_DIR.DS.'accounts'.DS.$auth->read('Account.id').DS.'logo'.DS.'account.png';
              $logoAction = __('Upload logo',true);
              
              if(file_exists($imageFile))
              {
                echo $image->resize($imageFile,230,110);
                $logoAction = __('Change',true);
              }
              else
              {
                echo '<span>'.__('No logo uploaded',true).'</span>';
              }
            ?></div>
            <p class="type"><strong><?php __('Your logo'); ?></strong> (<?php echo $html->link($logoAction,array('action'=>'logo','account')); ?>)</p>
            <p class="info"><?php __('Your logo appears on the sign in screen, the Dashboard, and Overview pages.'); ?></p>
          </div>
          
          <div class="col apple">
            <div class="image"><?php
              $imageFile = ASSETS_DIR.DS.'accounts'.DS.$auth->read('Account.id').DS.'logo'.DS.'apple.png';
              
              if(file_exists($imageFile))
              {
                echo $image->resize($imageFile,114,114);
              }
              else
              {
                echo $html->image('/apple-touch-icon.png');
              }
            ?></div>
            <p class="type"><strong><?php __('iPhone/iPad icon'); ?></strong> (<?php echo $html->link(__('Change',true),array('action'=>'logo','apple')); ?>)</p>
            <p class="info"><?php __('Appears when you add a home screen icon on your iPhone, iPad, or iPod Touch (apple-touch-icon.png).'); ?></p>
          </div>
          
          <div class="col shortcut">
            <div class="image"><?php
              $imageFile = ASSETS_DIR.DS.'accounts'.DS.$auth->read('Account.id').DS.'logo'.DS.'shortcut.ico';
              
              if(file_exists($imageFile))
              {
                echo $image->resize($imageFile,16,16);
              }
              else
              {
                echo $html->image('/favicon-16.ico');
              }
            ?></div>
            <p class="type"><strong><?php __('Shortcut icon'); ?></strong> (<?php echo $html->link(__('Change',true),array('action'=>'logo','shortcut')); ?>)</p>
            <p class="info"><?php __('Your shortcut icon, or favicon, appears in some web browsers on the address bar, tabs or bookmarks menu.'); ?></p>
          </div>
          
        </div>
        
        
        <hr />
        
      
        
        <h3><?php __('Your site name'); ?></h3>
        <p class="intro"><?php __('The site name appears at the top of every page.'); ?></p>
        <fieldset class="tight">
          <?php
            echo $form->input('name',array('label'=>false));
          ?>
        </fieldset>
        
        <?php
          echo $form->submit(__('Save changes',true));
          
          echo $form->end();
        ?>
        
      </div>
    </div>


  </div>
  <div class="col right">
  
    <div class="area">
      <div class="banner"><h3><?php __('Tip'); ?></h3></div>
      <div class="content">
        <p><?php
          $companyLink = $html->link(__('All People',true),array('controller'=>'companies','action'=>'index'));
          __(sprintf('To add or edit the people in your company, go to the \'%s\' page.',$companyLink));
        ?></p>
      </div>
    </div>
  
  </div>
</div>
