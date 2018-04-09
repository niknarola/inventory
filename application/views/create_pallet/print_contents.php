<table class="table" id="product_tbl" style="width:100%" border="1">    
    <thead>
        <tr>
            <th>#</th>
            <th>Serial #</th>
            <th>Part #</th>
            <th>Name</th>
            <!-- <th>Location</th> -->
        </tr>
    </thead>
    <tbody id="userData">
        <?php $i=1; ?>
        <?php if(!empty($serials)) { foreach ($serials as $serial){ ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $serial['serial']; ?></td>
            <td><?php echo $serial['part']; ?></td>
            <td><?php echo $serial['name']; ?></td>
            <!-- <td><?php //echo $serial['location_name']; ?></td> -->
        </tr>
            <?php   $i++; }  } else{ ?>
            <tr><td colspan="4">Serial(s) not found......</td></tr>
            <?php } ?>
    </tbody>
</table>
