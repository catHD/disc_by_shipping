<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/total.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><?php echo $entry_code; ?></td>
            <td><select name="disc_by_shipping_code"> 
                <?php foreach ($shipping as $code) {
                         echo '<option value="'.$code.'" '.($code == $disc_by_shipping_code ? 'selected' : '').'>'.$code."</option>\n";
                      } ?>
                </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_amount; ?></td>
            <td><input type="text" name="disc_by_shipping_amount" value="<?php echo $disc_by_shipping_amount; ?>" />
                <?php echo $entry_percent; ?>
                <input type="checkbox" name="disc_by_shipping_percent" <?php if (!empty($disc_by_shipping_percent)) echo 'checked' ?> /> 
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_range; ?></td>
            <td><input type="text" name="disc_by_shipping_min" value="<?php echo $disc_by_shipping_min; ?>" /> - 
                <input type="text" name="disc_by_shipping_max" value="<?php echo $disc_by_shipping_max; ?>" />
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_msg; ?></td>
            <td><?php foreach ($languages as $language) { ?>
                  <input type=text name="disc_by_shipping_msg[<?php echo $language['language_id']; ?>]" value="<?php
                    echo isset($disc_by_shipping_msg[$language['language_id']]) ?  $disc_by_shipping_msg[$language['language_id']] : ''; ?>" size=50>
                  <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" align="top" /><br />
                  <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_categories; ?></td>
            <td><select name="disc_by_shipping_categories[]" multiple>
                <?php foreach ($categories as $category) {  
                    echo '<option value="'.$category['category_id'].'"'.(in_array($category['category_id'],$disc_by_shipping_categories) ? 'selected': '' ).'>'.$category['name'].'</option>';
                } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="disc_by_shipping_status">
                <?php if ($disc_by_shipping_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="disc_by_shipping_sort_order" value="<?php echo $disc_by_shipping_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 
