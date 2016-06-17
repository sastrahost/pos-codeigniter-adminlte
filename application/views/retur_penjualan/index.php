<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaksi Retur Penjualan
        <small>List Retur Transaksi</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation"><a href="<?php echo site_url('retur_penjualan/create');?>">Input Retur Penjualan</a></li>
            <li role="presentation" class="active"><a href="<?php echo site_url('retur_penjualan');?>">List Retur Penjualan</a></li>
          </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table Penjualan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo site_url('penjualan?search=true');?>" method="GET">
                <input type="hidden" class="form-control" name="search" value="true"/>
                <div class="box-body pad">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="id">Code Penjualan</label>
                      <input type="text" class="form-control" name="id" value="<?php echo !empty($_GET['id']) ? $_GET['id'] : '';?>"/>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Date From</label>
                      <div class="input-group date">
                        <input type="text" class="form-control datepicker-transaksi" name="date_from" value="<?php echo !empty($_GET['date_from']) ? $_GET['date_from'] : '';?>"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Date End</label>
                      <div class="input-group date">
                        <input type="text" class="form-control datepicker-transaksi" name="date_end" value="<?php echo !empty($_GET['date_end']) ? $_GET['date_end'] : '';?>"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="submit">&nbsp</label>
                      <input type="submit" value="Cari" class="form-control btn btn-primary">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="submit">&nbsp</label>
                      <a href="<?php echo site_url('retur_penjualan/export_csv');?>" class="form-control btn btn-default"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    </div>
                  </div>
                </div>
              </form>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Retur ID</th>
                  <th>Sales TRX ID</th>
                  <th>Total Item</th>
                  <th>Total Harga</th>
                  <th>Pengembalian Barang</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($penjualans) && is_array($penjualans)){ ?>
                  <?php foreach($penjualans as $penjualan){?>
						<tr>
						  <td><?php echo $penjualan->id;?></td>
						  <td>
							<?php echo $penjualan->sales_id;?>
							<a target="_blank" href="<?php echo site_url('penjualan/detail').'/'.$penjualan->sales_id;?>" class="btn btn-xs btn-primary">
							  detail
							</a>
						  </td>
						  <td><?php echo $penjualan->total_item;?></td>
						  <td>Rp<?php echo number_format($penjualan->total_price);?></td>
						  <td><?php echo $penjualan->is_return == 1 ? "Complete" : "Not Complete";?></td>
						  <td><?php echo $penjualan->date;?></td>
						  <td>
							<?php if($penjualan->is_return == 0){?>
								<a href="<?php echo site_url('retur_penjualan/edit').'/'.$penjualan->id;?>" class="btn btn-xs btn-default">Edit</a>
							<?php }else{ ?>
								<span class="btn-xs btn-success">Complete</span>		
							<?php } ?>
							
							<a onclick="return confirm('Are you sure you want to delete this penjualan?');" href="<?php echo site_url('retur_penjualan/delete').'/'.$penjualan->id;?>" class="btn btn-xs btn-danger">Delete</a>
						  </td>
						</tr>
                  <?php } ?>
                <?php } ?>
                </tbody>
                <tfoot>
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