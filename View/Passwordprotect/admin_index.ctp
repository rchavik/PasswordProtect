<div class="passwordprotect index">
    <h2><?php echo $title_for_layout; ?></h2>
    
    <?php
      //Checks
      $error = false;
      if(!file_exists($htaccess)) { echo '<p class="error">'.__('Htaccess file missing, create it first').' ('.$htaccess.')</p>'; $error = true; }
      if(!file_exists($htpasswd)) { echo '<p class="error">'.__('Htpasswd file missing, create it first').' ('.$htpasswd.')</p>'; $error = true; }
    ?>
    
    <?php if(!$error): ?>

      <div class="actions">
          <ul>
              <?php if(!$enabled): ?><li><?php echo $this->Html->link(__('Enable Password Protection'), array('action'=>'enable')); ?></li><?php endif; ?>
              <?php if($enabled): ?><li><?php echo $this->Html->link(__('Disable Password Protection'), array('action'=>'disable')); ?></li><?php endif; ?>
              <li><?php echo $this->Html->link(__('Add User'), array('action'=>'add')); ?></li>
          </ul>
      </div>

      <table cellpadding="0" cellspacing="0">
      <?php
          $tableHeaders =  $this->Html->tableHeaders(array(
              'Username',
              __('Actions'),
          ));
          echo $tableHeaders;

          $rows = array();
          foreach ($records AS $key => $record) {
              $actions  = $this->Html->link(__('Edit'), array('action' => 'edit', $record['Htpasswd']['username']));
              $actions .= ' ' . $this->Html->link(__('Delete'), array(
                  'action' => 'delete',
                  $record['Htpasswd']['username'],
                  'token' => $this->params['_Token']['key'],
              ), null, __('Are you sure?'));

              $rows[] = array(
                  $record['Htpasswd']['username'],
                  $actions,
              );
          }

          echo $this->Html->tableCells($rows);
          echo $tableHeaders;
      ?>
      </table>
      
    <?php endif; ?>
    
</div>
