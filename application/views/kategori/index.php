<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Kategori Index
                <small>List Kategori</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <li role="presentation"><a href="<?php echo site_url('kategori/create');?>">Input Kategori</a></li>
                        <li role="presentation" class="active"><a href="<?php echo site_url('kategori');?>">List Kategori</a></li>
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Table Kategori</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form action="<?php echo site_url('kategori?search=true');?>" method="GET">
                                <input type="hidden" class="form-control" name="search" value="true"/>
                                <div class="box-body pad">
                                    <?php echo search_form('category');?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="submit">&nbsp</label>
                                            <input type="submit" value="Submit" class="form-control btn btn-primary">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="submit">&nbsp</label>
                                            <a href="<?php echo site_url('kategori/export_csv');?>" class="form-control btn btn-default"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Code ID</th>
                                    <th>Kategori Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($kategoris) && is_array($kategoris)){ ?>
                                    <?php foreach($kategoris as $kategori){?>
                                        <tr>
                                            <td><?php echo $kategori->id;?></td>
                                            <td><?php echo $kategori->category_name;?></td>
                                            <td><?php echo $kategori->category_desc;?></td>
                                            <td>
                                                <a href="<?php echo site_url('kategori/edit').'/'.$kategori->id;?>" class="btn btn-xs btn-primary">Edit</a>
                                                <a onclick="return confirm('Are you sure you want to delete this kategori?');" href="<?php echo site_url('kategori/delete').'/'.$kategori->id;?>" class="btn btn-xs btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Code ID</th>
                                    <th>Kategori Name</th>
                                    <th>Description</th>
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