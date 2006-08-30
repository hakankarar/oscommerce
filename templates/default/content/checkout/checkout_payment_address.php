<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2006 osCommerce

  Released under the GNU General Public License
*/
?>

<?php echo osc_image(DIR_WS_IMAGES . 'table_background_delivery.gif', $osC_Template->getPageTitle(), null, null, 'id="pageIcon"'); ?>

<h1><?php echo $osC_Template->getPageTitle(); ?></h1>

<?php
  if ($messageStack->size('checkout_address') > 0) {
    echo $messageStack->output('checkout_address');
  }
?>

<form name="checkout_address" action="<?php echo osc_href_link(FILENAME_CHECKOUT, $osC_Template->getModule() . 'process', 'SSL'); ?>" method="post" onsubmit="return check_form_optional(checkout_address);">

<?php
  if (isset($_GET[$osC_Template->getModule()]) && ($_GET[$osC_Template->getModule()] != 'process')) {
    if ($osC_Customer->hasDefaultAddress()) {
?>

<div class="moduleBox">
  <h6><?php echo $osC_Language->get('billing_address_title'); ?></h6>

  <div class="content">
    <div style="float: right; padding: 0px 0px 10px 20px;">
      <?php echo osC_Address::format($osC_ShoppingCart->getBillingAddress(), '<br />'); ?>
    </div>

    <div style="float: right; padding: 0px 0px 10px 20px; text-align: center;">
      <?php echo '<b>' . $osC_Language->get('current_billing_address_title') . '</b><br />' . osc_image(DIR_WS_IMAGES . 'arrow_south_east.gif'); ?>
    </div>

    <?php echo $osC_Language->get('selected_billing_destination'); ?>

    <div style="clear: both;"></div>
  </div>
</div>

<?php
    }

    if (osC_AddressBook::numberOfEntries() > 1) {
?>

<div class="moduleBox">
  <h6><?php echo $osC_Language->get('address_book_entries_title'); ?></h6>

  <div class="content">
    <div style="float: right; padding: 0px 0px 10px 20px; text-align: center;">
      <?php echo '<b>' . $osC_Language->get('please_select') . '</b><br />' . osc_image(DIR_WS_IMAGES . 'arrow_east_south.gif'); ?>
    </div>

    <p style="margin-top: 0px;"><?php echo $osC_Language->get('select_another_billing_destination'); ?></p>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
      $radio_buttons = 0;

      $Qaddresses = $osC_Template->getListing();

      while ($Qaddresses->next()) {
?>

      <tr>
        <td width="10">&nbsp;</td>
        <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
       if ($Qaddresses->valueInt('address_book_id') == $osC_ShoppingCart->getBillingAddress('id')) {
          echo '          <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
        } else {
          echo '          <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
        }
?>

            <td width="10">&nbsp;</td>
            <td colspan="2"><b><?php echo $Qaddresses->valueProtected('firstname') . ' ' . $Qaddresses->valueProtected('lastname'); ?></b></td>
            <td align="right"><?php echo osc_draw_radio_field('address', $Qaddresses->valueInt('address_book_id'), $osC_ShoppingCart->getBillingAddress('id')); ?></td>
            <td width="10">&nbsp;</td>
          </tr>
          <tr>
            <td width="10">&nbsp;</td>
            <td colspan="3"><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10">&nbsp;</td>
                <td><?php echo osC_Address::format($Qaddresses->toArray(), ', '); ?></td>
                <td width="10">&nbsp;</td>
              </tr>
            </table></td>
            <td width="10">&nbsp;</td>
          </tr>
        </table></td>
        <td width="10">&nbsp;</td>
      </tr>

<?php
        $radio_buttons++;
      }
?>

    </table>
  </div>
</div>

<?php
    }
  }

  if (osC_AddressBook::numberOfEntries() < MAX_ADDRESS_BOOK_ENTRIES) {
?>

<div class="moduleBox">
  <h6><?php echo $osC_Language->get('new_billing_address_title'); ?></h6>

  <div class="content">
    <?php echo $osC_Language->get('new_billing_address'); ?>

    <div style="margin: 10px 30px 10px 30px;">
      <?php require('includes/modules/address_book_details.php'); ?>
    </div>
  </div>
</div>

<?php
  }
?>

<br />

<div class="moduleBox">
  <div class="content">
    <div style="float: right;">
      <?php echo osc_draw_image_submit_button('button_continue.gif', $osC_Language->get('button_continue')); ?>
    </div>

    <?php echo '<b>' . $osC_Language->get('continue_checkout_procedure_title') . '</b><br />' . $osC_Language->get('continue_checkout_procedure_to_payment'); ?>
  </div>
</div>

</form>
