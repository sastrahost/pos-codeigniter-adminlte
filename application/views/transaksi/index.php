<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaksi Sales
        <small>List Transaksi</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation"><a href="<?php echo site_url('transaksi/create');?>">Input Transaksi</a></li>
            <li role="presentation" class="active"><a href="<?php echo site_url('transaksi');?>">List Transaksi</a></li>
          </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table Transaksi</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo site_url('transaksi?search=true');?>" method="GET">
                <input type="hidden" class="form-control" name="search" value="true"/>
                <div class="box-body pad">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="id">Code Transaksi</label>
                      <input type="text" class="form-control" name="id" value="<?php echo !empty($_GET['id']) ? $_GET['id'] : '';?>"/>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Date</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" id="datepicker-transaksi" name="date" value="<?php echo !empty($_GET['date']) ? $_GET['date'] : '';?>"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="submit">&nbsp</label>
                      <input type="submit" value="Submit" class="form-control btn btn-primary">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="submit">&nbsp</label>
                      <a href="<?php echo site_url('transaksi/export_csv');?>" class="form-control btn btn-default"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    </div>
                  </div>
                </div>
              </form>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Transaksi ID</th>
                  <th>Supplier Name</th>
                  <th>Total Item</th>
                  <th>Total Harga</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($transaksis) && is_array($transaksis)){ ?>
                  <?php foreach($transaksis as $transaksi){?>
                    <tr>
                      <td><?php echo $transaksi->id;?></td>
                      <td><?php echo $transaksi->supplier_name;?></td>
                      <td><?php echo $transaksi->total_item;?></td>
                      <td>Rp<?php echo number_format($transaksi->total_price);?></td>
                      <td><?php echo $transaksi->date;?></td>
                      <td>
                        <a href="<?php echo site_url('transaksi/detail').'/'.$transaksi->id;?>" class="btn btn-xs btn-default">Detail</a>
                        <a href="<?php echo site_url('transaksi/edit').'/'.$transaksi->id;?>" class="btn btn-xs btn-primary">Edit</a>
                        <a onclick="return confirm('Are you sure you want to delete this transaction?');" href="<?php echo site_url('transaksi/delete').'/'.$transaksi->id;?>" class="btn btn-xs btn-danger">Delete</a>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Code ID</th>
                  <th>Supplier Name</th>
                  <th>Total Item</th>
                  <th>Total Harga</th>
                  <th>Date</th>
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