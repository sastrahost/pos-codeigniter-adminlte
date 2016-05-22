<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Supplier Form
        <small>List Supplier</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Supplier Form</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('supplier/create');?>">Input Supplier</a></li>
            <li role="presentation"><a href="<?php echo site_url('supplier');?>">List Supplier</a></li>
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Supplier</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($supplier)){?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('supplier/save').'/'.$supplier['id'];?>">
            <?php }else{?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('supplier/save');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="kode">Kode Supplier</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($supplier) ? $supplier['id'] : $code_supplier;?>" id="kode" class="form-control" disabled/>
                      <input type="hidden" name="supplier_id" value="<?php echo !empty($supplier) ? $supplier['id'] : $code_supplier;?>" id="suplier_id" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="name">Name</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($supplier) ? $supplier['supplier_name'] : '';?>" name="supplier_name" placeholder="Supplier Name" id="name" class="form-control" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="address">Address</label>
                    <div class="col-sm-8">
                      <textarea name="supplier_address" placeholder="Address" id="address" class="form-control"/><?php echo !empty($supplier) ? $supplier['supplier_address'] : '';?></textarea>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="date">Tanggal</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($supplier) ? $supplier['date'] : date('Y-m-d H:i:s');?>" id="date" class="form-control" disabled/>
                      <input type="hidden" name="supplier_date" value="<?php echo !empty($supplier) ? $supplier['date'] : date('Y-m-d H:i:s');?>" id="supplier_date" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="phone">No Telp</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($supplier) ? $supplier['supplier_phone'] : '';?>" name="supplier_phone" placeholder="Phone" id="phone" class="form-control"/>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('supplier');?>">Cancel</a>
                <button class="btn btn-info pull-right" type="submit">Save</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
		</div>
        <!-- /.col -->
      </div>
	  <!-- row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('element/footer');?>