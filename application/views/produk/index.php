<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Produk Index
                <small>List Produk</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <li role="presentation"><a href="<?php echo site_url('produk/create');?>">Input Produk</a></li>
                        <li role="presentation" class="active"><a href="<?php echo site_url('produk');?>">List Produk</a></li>
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Table Produk</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form action="<?php echo site_url('produk?search=true');?>" method="GET">
                                <input type="hidden" class="form-control" name="search" value="true"/>
                                <div class="box-body pad">
                                    <?php echo search_form('product');?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="submit">&nbsp</label>
                                            <input type="submit" value="Cari" class="form-control btn btn-primary">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="submit">&nbsp</label>
                                            <a href="<?php echo site_url('produk/export_csv');?>" class="form-control btn btn-default"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Code ID</th>
                                    <th>Produk Name</th>
                                    <th>Description</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                    <th>Price 1</th>
                                    <th>Price 2</th>
                                    <th>Price 3</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($produks) && is_array($produks)){ ?>
                                    <?php foreach($produks as $produk){?>
                                        <tr>
                                            <td><?php echo $produk->id;?></td>
                                            <td><?php echo $produk->product_name;?></td>
                                            <td><?php echo $produk->product_desc;?></td>
                                            <td><?php echo $produk->product_qty;?></td>
                                            <td><?php echo $produk->sale_price;?></td>
                                            <td><?php echo $produk->sale_price_type1;?></td>
                                            <td><?php echo $produk->sale_price_type2;?></td>
                                            <td><?php echo $produk->sale_price_type3;?></td>
                                            <td>
                                                <a href="<?php echo site_url('produk/edit').'/'.$produk->id;?>" class="btn btn-xs btn-primary">Edit</a>
                                                <a onclick="return confirm('Are you sure you want to delete this product?');" href="<?php echo site_url('produk/delete').'/'.$produk->id;?>" class="btn btn-xs btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Code ID</th>
                                    <th>Produk Name</th>
                                    <th>Description</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                    <th>Price 1</th>
                                    <th>Price 2</th>
                                    <th>Price 3</th>
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