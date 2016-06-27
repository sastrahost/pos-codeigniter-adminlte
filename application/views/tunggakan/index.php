<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tunggakan
        <small>List Tunggakan</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('tunggakan');?>">List Tunggakan</a></li>
          </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table Tunggakan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo site_url('tunggakan?search=true');?>" method="GET">
                <input type="hidden" class="form-control" name="search" value="true"/>
                <div class="box-body pad">
                  <div class="col-md-1">
                    <div class="form-group">
                      <label>&nbsp</label>
                      <a href="#" id="tunggakan-reset" class="btn btn-default btn-sm pull-left">Reset</a>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="id">Kode Penjualan</label>
                      <input type="text" class="form-control" name="id" value="<?php echo !empty($_GET['id']) ? $_GET['id'] : '';?>"/>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Date From</label>
                      <select class="form-control" name="date_range" id="tunggakan-date-range">
                        <option value="">Pilih Hari</option>
                        <option value="7" <?php echo !empty($_GET['date_range']) && $_GET['date_range'] == 7 ? "selected":"";?>>7 Hari</option>
                        <option value="14" <?php echo !empty($_GET['date_range']) && $_GET['date_range'] == 14 ? "selected":"";?>>14 Hari</option>
                        <option value="30" <?php echo !empty($_GET['date_range']) && $_GET['date_range'] == 30 ? "selected":"";?>>30 Hari</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Date Transaction</label>
                      <div class="input-group date">
                        <input type="text" class="form-control datepicker" name="date_trx" value="<?php echo !empty($_GET['date_trx']) ? $_GET['date_trx'] : '';?>"/>
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
                      <a href="<?php echo site_url('tunggakan/export_csv');?>" class="form-control btn btn-default"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    </div>
                  </div>
                </div>
              </form>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Transaksi ID</th>
                  <th>Customer Name</th>
                  <th>Total Item</th>
                  <th>Total Harga</th>
                  <th>Tunggakan</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($tunggakans) && is_array($tunggakans)){ ?>
                  <?php foreach($tunggakans as $tunggakan){?>
                    <tr>
                      <td><?php echo $tunggakan->id;?></td>
                      <td><?php echo $tunggakan->customer_name;?></td>
                      <td><?php echo $tunggakan->total_item;?></td>
                      <td>Rp<?php echo number_format($tunggakan->total_price);?></td>
                      <td><?php echo $tunggakan->pay_deadline_date;?></td>
                      <td>
                        <a href="<?php echo site_url('tunggakan/detail').'/'.$tunggakan->id;?>" class="btn btn-xs btn-default">Detail</a>
                        <a onclick="return confirm('Are you sure you want to delete this tunggakan?');" href="<?php echo site_url('tunggakan/delete').'/'.$tunggakan->id;?>" class="btn btn-xs btn-danger">Delete</a>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } ?>
                </tbody>
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