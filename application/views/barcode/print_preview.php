<?php $i = 1; ?> 
<?php foreach ($print_labels as $key => $value){ 
    $orig = base_url().'assets/images/barcode/'.$value['pallet_id'].'.png';
    ?>
    <div style="padding-top:20%">
        <table style="width:100%;">
            <tbody>
                <tr><td style="text-align:center; padding:5px 10px; font-size:30px">BOL # <?php echo $value['bol_or_tracking'] ?></td></tr>
                <tr><td style="text-align:center; padding:5px 10px; font-size:30px"><b>Pallet <?php echo $i.'/'.$value['pallet_part'] ?></b> - Item Count: <?php echo $value['item_count'] ?></td></tr>
                <tr><td style="text-align:center; padding:0 0 10px 0; font-size:60px"><b><u><?php echo $value['pallet_id'] ?></b></u></td></tr>
                <tr><td style="text-align:center"><img style="margin-bottom: 5px;" src="<?php echo $orig; ?>"/></td></tr>
                <tr><td style="text-align:center; padding:20px 0 0px 0; font-size:20px"><b>Ref Number: <?php echo $value['ref'] ?></b></td></tr>
            </tbody>
        </table>
    </div>
    
    <div style="padding-top:20%">
        <table style="width:100%">
            <tbody>
                <tr><td style="text-align:center; padding:5px 10px; font-size:30px">BOL # <?php echo $value['bol_or_tracking'] ?></td></tr>
                <tr><td style="text-align:center; padding:5px 10px; font-size:30px"><b>Pallet <?php echo $i.'/'.$value['pallet_part'] ?></b> - Item Count: <?php echo $value['item_count'] ?></td></tr>
                <tr><td style="text-align:center; padding:0 0 10px 0; font-size:60px"><b><u><?php echo $value['pallet_id'] ?></b></u></td></tr>
                <tr><td style="text-align:center"><img style="margin-bottom: 5px;" src="<?php echo $orig; ?>"/></td></tr>
                <tr><td style="text-align:center; padding:20px 0 0px 0; font-size:20px"><b>Ref Number: <?php echo $value['ref'] ?></b></td></tr>
            </tbody>
        </table>
    </div>
<?php $i++; } ?>