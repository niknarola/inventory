<?php  //pr($specs);?>
<table class="table table-bordered">
    <tr>
        <td>CPU:</td>
        
        <td><?= (!empty($specs['cpu'])) ? implode(',',json_decode($specs['cpu'], true)) : 'Not Available' ?></td>
    </tr>
    <tr>
        <td>Storage:</td>
        <td>
            <?php 
            if(!empty($specs['storage'])){
                foreach(json_decode($specs['storage']) as $key => $value){ 
                    $ssd = json_decode($specs['ssd']);
                    if($ssd[$key] == 0){
                        echo $value.'<br>';
                    }
                    else{
                        echo $value.'(ssd)<br>';
                    }
                }
            }else{
                echo"Not available";
            }
                ?>
        </td>
    </tr>
    <tr>
        <td>Memory:</td>
        <td><?= !empty($specs['memory']) ? $specs['memory'] : 'Not Available' ?></td>
    </tr>
    <tr>
        <td>Graphics:</td>
        <td>
            <?php 
            if(!empty($specs['graphics'])){
                foreach(json_decode($specs['graphics']) as $key => $value){ 
                    $dedicated = json_decode($specs['dedicated']);
                        if($dedicated[$key] == 0){
                            echo $value.'<br>';
                        }
                        else{
                            echo $value.'(dedicated)<br>';
                        }
                }
            }else{
                echo"Not available";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>Screen:</td>
        <td><?= !empty($specs['screen']) ? $specs['screen'] : 'Not Available' ?></td>
    </tr>    
    <tr>
        <td>OS:</td>
        <td><?= !empty($specs['os']) ? $specs['os'] : 'Not Available' ?></td>
    </tr>
    <tr>
        <td>Resolution:</td>
        <td><?= !empty($specs['resolution']) ? $specs['resolution'] : 'Not Available' ?></td>
    </tr>
    <tr>
        <td>Size:</td>
        <td><?= !empty($specs['size']) ? $specs['size'] : 'Not Available' ?></td>
    </tr>
    <tr>
        <td>Form Factor:</td>
        <td><?= !empty($specs['form_factor']) ? $specs['form_factor'] : 'Not Available' ?></td>
    </tr>
</table>
