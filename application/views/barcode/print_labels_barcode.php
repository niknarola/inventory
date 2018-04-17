<style>
	body { line-height: 1; }
	.barcode_labels span {font-size: 18px; color: #000;}
	.barcode_labels .row{ margin-bottom: 5px; }
	@page{ 	/*size: auto;*/   /* auto is the initial value */ 
    		margin: 1mm 0mm 0mm 0mm;  /* this affects the margin in the printer settings */ 
    		/*margin: 5mm 1mm 0mm 1mm;*/  /* this affects the margin in the printer settings */ 
    		/*transform: scale(.30);*/
		}
		/*.block { border: 1px solid #ddd; padding: 2px; }*/
		.pallet_id{ font-size: 	25px !important; }
		/*.bol{ padding: 2px; background-color: grey; color: #fff !important; }*/
</style>
<div class="hidden_barcode_div" id="hidden_barcode_div" style="display:none"></div>
<form id="pallet-labels" action="admin/barcode/print_labels_barcode" method="post">
    <div class="row hidden-print">
        <a href="<?= $admin_prefix ?>inventory/create_pallet" class="btn btn-success">Back To Create Pallet</a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="hidden-print" style="margin-bottom: 5px;">
              <!--   <div class="text-center">
                    <button type="button" class="btn btn-info print_all hidden-print">Print Preview All</button>
                </div> -->
            </div>
            <div class="printarea">
            
            
            </div>
        </div>
    </div>
    <div class="col-md-12">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Print Pallet Labels</h5>
            <div class="heading-elements"></div> 
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="table-responsive">
                    <div class="col-md-12">
                        <div class="col-md-6 form-group">

                            <!-- <select class="form-control barcode" name="barcode"> -->
                                <!-- <option>All Barcodes</option> -->
                                <?php //foreach ($print_labels as $key => $value):?>
                                    <!-- <option value="<?php echo $value?>"><?php echo $value ?></option> -->
                                <?php //endforeach; ?>
                            <!-- </select> -->
                        </div>
                        <!-- <div class="col-md-6">
                            <button class="btn bg-teal search_barcode" name="search_barcode">Search</button>
                        </div> -->
                    </div>
                </div>
            </div>
            <?php if(isset($file_path)){ ?>
                <div class="row">
                    <div class="col-md-12">
                        <embed src="<?php echo $file_path; ?>" type="application/pdf" width="100%" height="800px">;
                    </div>
                </div>
            <?php } ?>
        </div>
</form>


<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('button.print_btn').click(function(){
			$('div.printarea div.print-panel').removeClass('hidden-print').addClass('hidden-print');
			$(this).parents('div.print-panel').removeClass('hidden-print');
			$('hr').removeClass('hidden-print').addClass('hidden-print');
			// window.print();
		});
		$('button.search_barcode').click(function(){
            var barcode = $('.barcode').val();
            $.ajax({
                type: 'POST',
                url: 'admin/barcode/print_preview',
                async: false,
                dataType: 'JSON',
                success: function (response) {
                    console.log(response);
                    // $('.hidden_barcode_div').html(data);
                    // setTimeout(function(){
                    //     //window.print();
                    //     var mywindow = window.open('', 'PRINT', 'height=400,width=600');
                    //     // //mywindow.document.write('<h1>' + document.title  + '</h1>');
                    //     mywindow.document.write(document.getElementById('test_div').innerHTML);
                    //     mywindow.document.close();
                    //     mywindow.focus();
                    //     mywindow.print();
                    //     mywindow.close();
                    // },1000);
                }
            });
		// 	$('div.printarea div.print-panel').removeClass('hidden-print'); 
		// 	$('hr').removeClass('hidden-print');
		// 	window.print();
		});
	});
</script>
