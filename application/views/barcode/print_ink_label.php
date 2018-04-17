<?php
$orig = base_url() . 'assets/images/barcode/' . $print_labels['hp_part'] . '.png';
$orig1 = base_url() . 'assets/images/barcode/' . $print_labels['internal_part'] . '.png';
?>
<?php
if (isset($qty['print_qty']) && !empty($qty['print_qty'])) {
    for ($i = 1; $i <= $qty['print_qty']; $i++) {
        ?>
		<table style="border:5px solid #000; padding:25px; max-width:600px; width:100%; margin:15px auto; background:#fff; ">
			<thead>
				<tr>
					<th style="padding:0 0 40px; width:150px; text-align:left;">
						<h2 style="margin:0; padding:0; text-align:center;">
							<big style="font-size:120px; width:100% line-height:120px; display:table; font-weight:400;"><?=$print_labels['ink']?></big> <br/>
							<small style="color:#000; font-size:20px;  text-transform: uppercase; line-height: 100%; display: block;"><?=$print_labels['conditions']?></small>
						</h2>
					</th>
					<th style="padding:0 0 40px; text-align:right;">
						<h6 style="margin:0; padding:0;">
							<big style="font-size: 60px; text-transform: uppercase; color: #000; text-align: right; display: block; line-height: 100%; padding: 0 10px 0 0; font-weight: 500; display:block;"><?=$print_labels['type_code']?></big>
							<small style="background: #000; color: #fff; font-size: 44px; padding: 8px 10px; line-height: 40px; display: block; text-align: center; text-transform: uppercase; width: 160px; text-align: right; padding:5px 10px; display:block;"><?=$print_labels['color']?></small>
							<span style="display:block; text-align: right; padding: 3px 10px 0 0; font-size: 13px; line-height: 100%; display:block;">03/27/2018</span>
						</h6>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="padding:0 10px 10px;">
						<span style="align-items: center; padding:0 0 15px; vertical-align:top;">
							<img style="width:100%;" src="<?php echo $orig; ?>"/>
						</span>
					</td>
					<td style="padding:0 10px 10px;">
						<h6 style="padding:0; font-size: 90px; height:420px; background: #000; color: #fff; padding: 0 20px; display:block;  font-weight: 300; margin:0;">INK</h6>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center; padding:20px 0;">
						<h2 style="padding:0; font-size:86px; display:block; font-weight:400; line-height:100%; text-align:center; color:#000; margin:0;">QTY:<?=$qty['box_qty'];?></h2>
						<h6 style="margin:0; padding: 10px 0 0; font-size: 22px; display: block; text-align: center; line-height: normal; font-weight: 400; color:#000;"><?=$print_labels['name']?></h6>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2" style="padding:0 10px; text-align:center;">
						<span><img style="width:100%;" src="<?php echo $orig1; ?>"/></span>
					</td>
				</tr>
			</tfoot>
		</table>
		<?php
}
}
?>

