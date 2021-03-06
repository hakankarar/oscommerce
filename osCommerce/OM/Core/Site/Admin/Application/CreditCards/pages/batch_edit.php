<?php
/*
  osCommerce Online Merchant $osCommerce-SIG$
  Copyright (c) 2010 osCommerce (http://www.oscommerce.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License v2 (1991)
  as published by the Free Software Foundation.
*/

  use osCommerce\OM\Core\OSCOM;
?>

<h1><?php echo $OSCOM_Template->getIcon(32) . osc_link_object(OSCOM::getLink(), $OSCOM_Template->getPageTitle()); ?></h1>

<?php
  if ( $OSCOM_MessageStack->exists() ) {
    echo $OSCOM_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo osc_icon('edit.png') . ' ' . OSCOM::getDef('action_heading_batch_edit_cards'); ?></h3>

  <form name="ccEditBatch" class="dataForm" action="<?php echo OSCOM::getLink(null, null, 'BatchSave&Process'); ?>" method="post">

  <p><?php echo OSCOM::getDef('introduction_batch_edit_cards'); ?></p>

<?php
  $Qcc = $OSCOM_Database->query('select id, credit_card_name from :table_credit_cards where id in (":id") order by credit_card_name');
  $Qcc->bindRaw(':id', implode('", "', array_unique(array_filter(array_slice($_POST['batch'], 0, MAX_DISPLAY_SEARCH_RESULTS), 'is_numeric'))));
  $Qcc->execute();

  $names_string = '';

  while ( $Qcc->next() ) {
    $names_string .= osc_draw_hidden_field('batch[]', $Qcc->valueInt('id')) . '<b>' . $Qcc->valueProtected('credit_card_name') . '</b>, ';
  }

  if ( !empty($names_string) ) {
    $names_string = substr($names_string, 0, -2);
  }

  echo '<p>' . $names_string . '</p>';

  echo '<p>' . osc_draw_radio_field('type', array(array('id' => 'activate', 'text' => OSCOM::getDef('activate')), array('id' => 'deactivate', 'text' => OSCOM::getDef('deactivate'))), 'activate') . '</p>';
?>

  <p><?php echo osc_draw_button(array('priority' => 'primary', 'icon' => 'check', 'title' => OSCOM::getDef('button_save'))) . ' ' . osc_draw_button(array('href' => OSCOM::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => OSCOM::getDef('button_cancel'))); ?></p>

  </form>
</div>
