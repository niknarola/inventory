<?php $i = 1; ?> 
<?php //foreach ($print_labels as $key => $value){ 
    $orig = base_url().'assets/images/barcode/'.$print_labels.'.png';
    ?>
    <div style="padding-top:50%">
        <table style="width:100%;">
            <tbody>
                <tr><td style="text-align:center; padding:0 0 10px 0; font-size:80px"><b><u><?php echo $print_labels; ?></b></u></td></tr>
                <tr><td style="text-align:center"><img style="margin-bottom: 5px;" src="<?php echo $orig; ?>"/></td></tr>
            </tbody>
        </table>
    </div>
    
    <div style="padding-top:70%">
        <table style="width:100%">
            <tbody>
                <tr><td style="text-align:center; padding:0 0 10px 0; font-size:80px"><b><u><?php echo $print_labels; ?></b></u></td></tr>
                <tr><td style="text-align:center"><img style="margin-bottom: 5px;" src="<?php echo $orig; ?>"/></td></tr>
            </tbody>
        </table>
    </div>
<?php $i++; //} ?>
