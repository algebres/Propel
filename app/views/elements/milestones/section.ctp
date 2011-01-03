
<div class="section small <?php echo $class; ?> indented">
  <div class="banner">
    <h3><?php echo $title; ?></h3>
  </div>
  <div class="content">
  
    <?php if(isset($calendar) && $calendar == true): ?>
      <h3 class="sub"><?php __('Due in the next 14 days'); ?></h3>
      <?php
        echo $this->element('calendar/month',array('type'=>'short','month'=>date('n'),'year'=>date('Y')));
      ?>
      <br />
      <h3 class="sub"><?php __('All upcoming'); ?></h3>
    <?php endif; ?>
  
    <div class="listable">
    
      <?php
        //Group records by date
        if(!isset($dateKey)) { $dateKey = 'deadline'; }
        
        $grouped = array();
        foreach($records as $record)
        {
          $key = strtotime($record['Milestone'][$dateKey]).'::'.$record['Responsible']['name'];
          if(!isset($grouped[$key])) { $grouped[$key] = array(); }
          
          $grouped[$key][] = $record;
        }
      ?>
      
      <?php foreach($grouped as $key => $records): ?>
      
        <?php
          $split = explode('::',$key);
          $date = $split[0];
          $responsibility = $split[1];
          
          $items = array();
          foreach($records as $milestone)
          {
            $items[] = array(
              'id'      => $milestone['Milestone']['id'],
              'title'   => $milestone['Milestone']['title'],
              'options' => array(
                'checked' => (isset($checked) && $checked) ? true : false
              )
            );
          }
          
          //Build title
          $titleParts = array();
          
          if($type == 'upcoming' || $type == 'overdue')
          {
            if(date('Y-m-d',$date) == date('Y-m-d'))
            {
              $titleParts[] = __('Today',true);
            }
            elseif(date('Y-m-d',$date) == date('Y-m-d',strtotime('+1 day')))
            {
              $titleParts[] = __('Tomorrow',true);
              $titleParts[] = '<span>('.date('l, j F',$date).')</span>';
            }
            elseif(date('Y-m-d',$date) == date('Y-m-d',strtotime('-1 day')))
            {
              $titleParts[] = __('Yesterday',true);
              $titleParts[] = '<span>('.date('l, j F',$date).')</span>';
            }
            elseif($type == 'overdue')
            {
              //Overdue fall back
              $total = ceil((time() - $date) / 86400);
            
              $titleParts[] = $total.' days ago';
              $titleParts[] = '<span>('.date('l, j F',$date).')</span>';
            }
            else
            {
              //Upcoming fall back
              $titleParts[] = date('l, j F',$date);
              
              $total = ceil($date / (time()+86400));
              if($total < 30)
              {
                $titleParts[] = '<span>('.$total.' day'.($total > 1 ? 's' : null).' away)</span>';
              }
            }
          }
          else
          {
            $titleParts[] = date('l, j F',$date);
          }
          
          $titleParts[] = '<span class="responsibility">'.$responsibility.'</span>';
          
          $title = implode(' ',$titleParts);
          
          //
          echo $listable->group('Milestone',$title,$items,array('class'=>'large'));
          
        ?>
        
      <?php endforeach; ?>
    
      
    </div>
  
  </div>
</div>
