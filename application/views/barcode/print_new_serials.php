<?php
if(isset($new_serial) && !empty($new_serial)){
	$orig = "";
	foreach($new_serial as $k =>$v){
		$orig = base_url() . 'assets/images/barcode/' . $v . '.png';
		?>
		<div class="barcode-wrap" style="padding-top:30px">
			<table style="width:100%;">
				<tbody>
					<tr><td style="text-align:center"><img style="margin-bottom: 5px;" src="<?php echo $orig; ?>"/></td></tr>
				</tbody>
			</table>
    	</div>
<?php }
	}
?>
<style>
.barcode-wrap{
	height:auto;
	width: 2.4in;
	text-align: center;
	margin: 0 auto;
}
</style>
