<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Produk Form
        <small>List Produk</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('produk/create');?>">Input Produk</a></li>
            <li role="presentation"><a href="<?php echo site_url('produk');?>">List Produk</a></li>
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Produk</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($produk)){?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('produk/save').'/'.$produk['id'];?>">
            <?php }else{?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('produk/save');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="kode">Kode Produk</label>
                    <div class="col-sm-8">
                      <input type="text" name="product_id" value="<?php echo !empty($produk) ? $produk['id'] : '';?>" id="kode_produk" class="form-control" autocomplete="off" required/>
                      <span class="help-inline label label-danger" id="status_kode"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="name">Nama Produk</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($produk) ? $produk['product_name'] : '';?>" name="product_name" placeholder="Product Name" id="name" class="form-control" required/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="date">Tanggal</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($produk) ? $produk['date'] : date('Y-m-d H:i:s');?>" id="date" class="form-control" disabled/>
                      <input type="hidden" name="product_date" value="<?php echo !empty($produk) ? $produk['date'] : date('Y-m-d H:i:s');?>" id="product_date" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="category_id">Kategori</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="category_id" name="category_id">
                        <?php if(isset($category) && is_array($category)){?>
                          <?php foreach($category as $item){?>
                            <option value="<?php echo $item->id;?>" <?php if(!empty($produk) && $item->id == $produk['category_id']) echo 'selected="selected"';?>>
                              <?php echo $item->category_name;?>
                            </option>
                          <?php }?>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="address">Deskripsi</label>
                    <div class="col-sm-10">
                      <textarea name="product_desc" placeholder="Description" id="desc" class="form-control"/><?php echo !empty($produk) ? $produk['product_desc'] : '';?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="address">Quantity</label>
                    <div class="col-sm-10">
                      <input type="number" value="<?php echo !empty($produk) ? $produk['product_qty'] : '';?>" name="product_qty" placeholder="Quantity" id="qty" class="form-control" disabled/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="address">Harga Jual</label>
                    <div class="col-sm-10">
                      <input type="text" value="<?php echo !empty($produk) ? $produk['sale_price'] : '';?>" name="sale_price" placeholder="Product Sale" id="sale" class="form-control" required/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="address">Harga Type 1</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($produk) ? $produk['sale_price_type1'] : '';?>" name="sale_price_type1" placeholder="Product Sale type 1" id="product_sale_type1" class="form-control"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="address">Harga Type 2</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($produk) ? $produk['sale_price_type2'] : '';?>" name="sale_price_type2" placeholder="Product Sale type 2" id="product_sale_type2" class="form-control"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="address">Harga Type 3</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($produk) ? $produk['sale_price_type3'] : '';?>" name="sale_price_type3" placeholder="Product Sale type 3" id="product_sale_type3" class="form-control"/>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="<?php echo site_url('produk');?>">Cancel</a>
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