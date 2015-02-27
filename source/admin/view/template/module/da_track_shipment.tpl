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
			<h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
		</div>
		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<table class="form">
					<tr>
						<td><?php echo $entry_status; ?></td>
						<td><select name="da_track_shipment_status">
							<?php if ($da_track_shipment_status) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
							<?php } else { ?>
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							<?php } ?>
						</select></td>
					</tr>
					<!-- aftership API -->
					<tr>
						<td><span class="required">*</span> <?php echo $entry_key; ?></td>
						<td><input type="text" name="da_track_shipment_after_ship_key" value="<?php echo $da_track_shipment_after_ship_key; ?>" style="width: 300px"/>
							<?php if ($error_key) { ?>
								<span class="error"><?php echo $error_key; ?></span>
							<?php } ?>
							<br />
							<?php echo $this->language->get('text_get_key'); ?>
						</td>
					</tr>
					<!-- username -->
					<tr>
						<td><span class="required">*</span> <?php echo $entry_username; ?></td>
						<td><input type="text" name="da_track_shipment_after_ship_username" value="<?php echo $da_track_shipment_after_ship_username; ?>" style="width: 300px"/>
							<?php if ($error_key) { ?>
								<span class="error"><?php echo $error_key; ?></span>
							<?php } ?>
							<br />
							<?php echo $this->language->get('text_get_username'); ?>
						</td>
					</tr>
					<tr>
						<td valign="top"><h3><?php echo $entry_courier; ?></h3></td>
						<td>
							<br/>
							<table>
								<?php for ($i=0;$i<count($couriers);$i++) { ?>
								<tr>
			                        <td><?php echo $couriers[$i]["name"]; ?></td>
								</tr>
								<?php } ?>
							</table>
							<br/>
							<div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_refresh; ?></a></div>
							<br/>
							<?php echo $this->language->get('text_refresh'); ?>
						</td>
					</tr>
				</table>

			</form>
		</div>
	</div>
</div>
<?php echo $footer; ?>
