<?php //pr($product_serial,1); ?>
<div class="panel-body">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<table class="table">
				<tbody>
					<tr>
						<td><b>Serial # :</b></td>
						<td><?= $product_serial['serial']; ?></td>
					</tr>
					<tr>
						<td><b>New Serial #:</b></td>
						<td><?= $product_serial['new_serial']; ?></td>
					</tr>
					<tr>
						<td><b>Condition :</b></td>
						<td><?= $product_serial['original_condition']; ?></td>
					</tr>
					<tr>
						<td><b>Cosmetic Grade :</b></td>
						<td><?= $product_serial['cosmetic_grade']; ?></td>
					</tr>
					<tr>
									<td><b>CPU :</b></td>
									<td><?= ($product_serial['cpu']) ? implode(',',json_decode($product_serial['cpu'], true)) : "Not available"; ?></td>
								</tr>
								<tr>
									<td><b>Memory :</b></td>
									<td><?= $product_serial['memory']; ?></td>
								</tr>
								<tr>
                                    <td><b>Storage :</b> <br/><b>SSD:</b>
                                    </td>
                                    <!-- <td><?//= $product_serial['storage']; ?><?//= ($product_serial['ssd'] == 1) ? ' SSD' : '' ; ?></td> -->
                                    <td><?= ($product_serial['storage']) ?  implode(',',json_decode($product_serial['storage'], true)) :"Not available";?> <br/>
                                    <?= ($product_serial['ssd']) ? implode(',',json_decode($product_serial['ssd'], true)) : "Not Available"?></td>
								</tr>
								<tr>
                                    <td><b>Graphics :</b><br/><b>Dedicated:</b>
                                    </td>
                                    <td><?= ($product_serial['graphics']) ? implode(',',json_decode($product_serial['graphics'], true)) : "Not available";?> <br/>
                                    <?= ($product_serial['dedicated']) ? implode(',',json_decode($product_serial['dedicated'], true)) : "Not available";?></td>
									<!-- <td><?//= $product_serial['graphics']; ?><?//= ($product_serial['dedicated'] == 1) ? ' Dedicated' : '' ; ?></td> -->
								</tr>
								<tr>
                                    <td><b>Screen :</b> <br/><b>Resolution:</b><br/><b>Size:</b></td>
                                    <td><?= $product_serial['screen']; ?><br/><?= $product_serial['resolution']; ?><br/><?= $product_serial['size']; ?></td>
									<!-- <td><?//= $product_serial['screen'].' '.$product_serial['size']; ?></td> -->
								</tr>
								<tr>
									<td><b>OS :</b></td>
									<td><?= $product_serial['os']; ?></td>
								</tr>
								<tr>
									<td><b>Touch Screen :</b></td>
									<td><?= ($product_serial['touch_screen'] == 1) ? 'Yes' : 'No' ; ?></td>
								</tr>
								<tr>
									<td><b>Webcam :</b></td>
									<td><?= ($product_serial['webcam'] == 1) ? 'Yes' : 'No' ; ?></td>
								</tr>
								<tr>
									<td><b>Recv Notes :</b></td>
									<td><?= $product_serial['recv_notes']; ?></td>
								</tr><tr>
									<td><b>Tech Notes :</b></td>
									<td><?= $product_serial['tech_notes']; ?></td>
								</tr>
				</tbody>
			</table>
			<div class="panel-body text-center">
				<a href="<?php echo $this->input->server('HTTP_REFERER'); ?>" class="btn btn-primary">Back</a>
			</div>
		</div>
	</div>
</div>
