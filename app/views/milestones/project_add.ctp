
<div class="box">
  <div class="banner">
    <h2><?php __('Add a new milestone'); ?></h2>
  </div>
  <div class="content">
    
    <?php
      echo $session->flash();
    ?>
    
    <?php
      echo $this->element('milestones/form');
    ?>
    
  </div>
</div>
