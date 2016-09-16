<?php $this->load->view('element/head');?>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>POS</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in untuk memulai aplikasi Point of Sale</p>
	
	<?php if($this->session->flashdata('login_false')){?>
		<div class="alert alert-danger alert-dismissible">
			<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<h4>
				<i class="icon fa fa-ban"></i>Alert!
			</h4>
			<?php echo $this->session->flashdata('login_false');?>
		</div>
	<?php } ?>
    
	<form action="<?php echo site_url('auth/login_process');?>" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
            <!--  <input type="checkbox" name="remember_me"> Remember Me -->
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

   <!-- <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a>-->

  </div>
  <!-- /.login-box-body -->
</div>
</body>
<?php $this->load->view('element/footer');?>