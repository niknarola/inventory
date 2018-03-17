<?php  //pr($specs);?>
<table class="table table-bordered">
    <tr>
        <td>CPU:</td>
        <td><?= !empty($specs['cpu']) ? implode(',',json_decode($specs['cpu'], true)) : 'Not Available' ?></td>
    </tr>
    <tr>
        <td>Storage:</td>
        <td><?= !empty($specs['storage']) ? implode(',',json_decode($specs['storage'], true)) : 'Not Available' ?></td>
    </tr>
    <tr>
        <td>SSD:</td>
        <td><?= !empty($specs['ssd']) ? implode(',',json_decode($specs['ssd'], true)) : 'Not Available' ?></td>
    </tr>
    <tr>
        <td>Memory:</td>
        <td><?= !empty($specs['memory']) ? $specs['memory'] : 'Not Available' ?></td>
    </tr>
    <tr>
        <td>Graphics:</td>
        <td><?= !empty($specs['graphics']) ? implode(',',json_decode($specs['graphics'], true)) : 'Not Available' ?></td>
    </tr>
    <tr>
        <td>Dedicated:</td>
        <td><?= !empty($specs['dedicated']) ? implode(',',json_decode($specs['dedicated'], true)) : 'Not Available' ?></td>
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
</table>
