<div class="row">
	<div class="">
    <!-- action="<?= $admin_prefix; ?>testing/other_item" -->
        <form method="post"  id="other" enctype="multipart/form-data">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <div class="row">
                        <div class="">
                            <h5 class="panel-title">Create Pallet</h5>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="pallet-top">
                        <div class="col-md-2  form-group">
                            <button class="btn bg-teal" type="submit">Pallet</button>
                        </div>
                        <div class="col-md-2 form-group">
                            <button class="btn bg-teal" type="submit">Cart</button>
                        </div>
                        <!-- <div class="col-md-2 form-group">
                            <button class="btn bg-teal" type="submit">INK</button>
                        </div> -->
                        <div class="col-md-2 form-group">
                            <button class="btn bg-teal" type="submit">Other</button>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control ">
                                    <option>Type</option>
                                    <option>Receiving</option>
                                    <option>Testing</option>
                                    <option>Packout</option>
                                    <option>Inventory</option>
                                </select>
                            </div> 
                        </div>
                    </div>

                    <div class="pallet-btm">
                        <div class="col-md-4 form-group">
                            <input type="text" value="" name="name" class="form-control name" placeholder="Serial Number#" required="">
                        </div>    
                        <div class="col-md-4 form-group">
                            <input type="text" value="" name="name" class="form-control name" placeholder="Part Number#" required="">
                        </div>    
                        <div class="col-md-2">
                            <i class="icon-plus-circle2 add_more_cpu"></i>
                        </div>
                    </div>

                    <div class="col-md-6">
                    <button class="btn bg-teal print_labels" type="submit">Print Labels</button>
                    <button class="btn bg-teal print_btn" type="submit">Print Contents</button>
                    <button class="btn bg-teal save_btn" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
	</div>
	<!-- <div class=""></div> -->
</div>