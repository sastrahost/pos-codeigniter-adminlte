<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Supplier Index
        <small>List Supplier</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Supplier Index</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li role="presentation"><a href="<?php echo site_url('supplier/create');?>">Input Supplier</a></li>
                <li role="presentation" class="active"><a href="<?php echo site_url('supplier');?>">List Supplier</a></li>
            </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table Suppliers</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo site_url('supplier?search=true');?>" method="GET">
                <input type="hidden" class="form-control" name="search" value="true"/>
                <div class="box-body pad">
                  <?php echo search_form('supplier');?>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="submit">&nbsp</label>
                      <input type="submit" value="Cari" class="form-control btn btn-primary">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="submit">&nbsp</label>
                      <a href="<?php echo site_url('supplier/export_csv');?>" class="form-control btn btn-default"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    </div>
                  </div>
                </div>
              </form>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Code ID</th>
                  <th>Supplier Name</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php if(isset($suppliers) && is_array($suppliers)){ ?>
				  <?php foreach($suppliers as $supplier){?>
					<tr>
                      <td><?php echo $supplier->id;?></td>
					  <td><?php echo $supplier->supplier_name;?></td>
					  <td><?php echo $supplier->supplier_phone;?></td>
					  <td><?php echo $supplier->supplier_address;?></td>
					  <td>
						<a href="<?php echo site_url('supplier/edit').'/'.$supplier->id;?>" class="btn btn-xs btn-primary">Edit</a>
						<a onclick="return confirm('Are you sure you want to delete this supplier?');" href="<?php echo site_url('supplier/delete').'/'.$supplier->id;?>" class="btn btn-xs btn-danger">Delete</a>
					  </td>
					</tr>
				  <?php } ?>
				<?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Code ID</th>
                  <th>Supplier Name</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="text-center">
              <?php echo $paggination;?>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
	  <!-- row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('element/footer');?>