<form method="post" action="admin/create_pallet/printed_contents" enctype="multipart/form-data">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<div class="row">
				<div class="">
					<h5 class="panel-title">Create Pallet</h5>
				</div>
			</div>
		</div>
		
		<div class="panel-body">
			<div class="row">
				<div class="col-md-3 form-group">
					<input type="text" value="" name="" class="form-control" placeholder="Internal P/N">
				</div>
				<div class="col-md-1 form-group chekbox-validation">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input type="checkbox" value="0" data-field="serial" name="serial_chk[]" class="serial_chk checkbx">
                        </span>
                    </div>
				</div>
				<div class="col-md-2 form-group">
					<input type="text" value="" name="" class="form-control" placeholder="Write here">
				</div>
				<div class="col-md-5 form-group">
					<button class="btn bg-teal" type="submit">Print Label</button>
					<!-- <button class="btn bg-teal" type="submit">Save</button> -->
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-5 form-group">
					<input type="text" value="" name="" class="form-control" placeholder="Scan to Location">
				</div>
				<div class="col-md-3 form-group">
					<button class="btn bg-teal" type="submit">Scan</button>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-2 form-group savelabel-new">
					<button class="btn bg-teal" type="submit">Saved Labels</button> <br/>
					<button class="btn bg-teal" type="submit">New</button>
				</div>
				<div class="col-md-4 form-group">
					<select class="form-control">
						<option>Label 01</option>
						<option>Label 02</option>
						<option>Label 03</option>
						<option>Label 04</option>
						<option>Label 05</option>
					</select>
				</div>
				<div class="col-md-2 form-group">
                    <input type="text" value="" name="" class="form-control" placeholder="Print Qty..">
                </div>
                <div class="col-md-3 form-group">
					<button class="btn bg-teal" type="submit">Print Label</button>
				</div>
			</div>
			
			
			
		</div>
	</div>
</form>