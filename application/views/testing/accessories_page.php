<?php
//var_dump($access);die;
if(!empty($access)){
	foreach($access as $key => $value){?>
<div class="input-group"><span class="input-group-addon"><input type="hidden" value="<?= $value->name;?>" name="access_type[]"><input type="checkbox" value="<?= (isset($value->value1) && isset($value->value2)) ? $value->value2 : $value->value1;?>" name="access_name[]" class="<?= (isset($value->value1) && isset($value->value2)) ? $value->value2 : $value->value1;?> checkbx"></span><label class="check_label"><?= (isset($value->value1) && isset($value->value2)) ? $value->value2 : $value->value1;?></label></div>
	<?php } }?>

