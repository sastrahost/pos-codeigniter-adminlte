<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaki Form
        <small>List Transaki</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Transaki Form</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('transaksi/create');?>">Input Transaki</a></li>
            <li role="presentation"><a href="<?php echo site_url('transaksi');?>">List Transaki</a></li>
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Transaki</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($transaksi)){?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('transaksi/save').'/'.$transaksi['id'];?>">
            <?php }else{?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('transaksi/save');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="kode">Kode Transaksi</label>
                    <div class="col-sm-8">
                      <input type="text" name="transaction_id" value="<?php echo !empty($transaksi) ? $transaksi['id'] : '';?>" id="kode_transaksi" class="form-control" required/>
                      <span class="help-inline label label-danger" id="status_kode"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="category_id">Supplier</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="supplier_id" name="supplier_id">
                        <?php if(isset($suppliers) && is_array($suppliers)){?>
                          <?php foreach($suppliers as $item){?>
                            <option value="<?php echo $item->id;?>" <?php if(!empty($transaksi) && $item->id == $transaksi['supplier_id']) echo 'selected="selected"';?>>
                              <?php echo $item->supplier_name;?>
                            </option>
                          <?php }?>
                        <?php }?>
                      </select>
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
                </div>
                <div class="col-md-11 col-md-offset-1">
                  <h3 class="content-title">Informasi Barang</h3>
                  <div class="content-process">
                    <table class="table">
                      <thead>
                        <tr>
                          <td>Kategori</td>
                          <td>Nama Barang</td>
                          <td>Jumlah</td>
                          <td>Harga Beli Satuan</td>
                          <td>Input Barang</td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <select class="form-control" id="transaksi_category_id" name="category_id">
                              <option value="0">
                                Please select one
                              </option>
                              <?php if(isset($kategoris) && is_array($kategoris)){?>
                                <?php foreach($kategoris as $item){?>
                                  <option value="<?php echo $item->id;?>" <?php if(!empty($transaksi) && $item->id == $transaksi['category_id']) echo 'selected="selected"';?>>
                                    <?php echo $item->category_name;?>
                                  </option>
                                <?php }?>
                              <?php }?>
                            </select>
                          </td>
                          <td>
                            <select class="form-control" id="transaksi_product_id" name="product_id"></select>
                          </td>
                          <td>
                            <input type="number" id="jumlah" class="form-control" name="jumlah" min="1" value="1"/>
                          </td>
                          <td>
                            <select class="form-control" id="sale_price" name="sale_price"></select>
                          </td>
                          <td>
                            <a href="#" class="btn btn-primary" id="tambah-barang">Input Barang</a>
                          </td>
                        </tr>
                        <tr id="transaksi-item">
                          <td>Kipas Angin Maspion</td>
                          <td>1000000</td>
                          <td>1000000</td>
                          <td><span class="btn btn-danger btn-sm transaksi-delete-item">x</span></td>
                        </tr>
                      </tbody>
                      <tfoot>
                      <tr>
                        <td>Total Pembelian</td>
                        <td>Rp 3.000.000</td>
                      </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-3 col-md-offset-4">
                  <a class="btn btn-default" href="<?php echo site_url('supplier');?>">Cancel</a>
                  <a class="btn btn-info pull-right" href="#" id="submit-transaksi">Submit</a>
                </div>
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