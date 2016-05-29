<?php if($this->is_login){?>
	<?php $this->load->view('element/main_footer');?>
	<?php $this->load->view('element/control_bar');?>
<?php } ?>
	</body>
	<footer>
		<!-- ./wrapper -->

		<!-- jQuery 2.2.0 -->
		<script src="<?php echo base_url('public');?>/plugins/jQuery/jQuery-2.2.0.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="<?php echo base_url('public');?>/js/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
		  $.widget.bridge('uibutton', $.ui.button);
		</script>
		<!-- Bootstrap 3.3.6 -->
		<script src="<?php echo base_url('public');?>/bootstrap/js/bootstrap.min.js"></script>
		<!-- Morris.js charts -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<!-- script src="<?php echo base_url('public');?>/plugins/morris/morris.min.js"></script -->
		<!-- Sparkline -->
		<script src="<?php echo base_url('public');?>/plugins/sparkline/jquery.sparkline.min.js"></script>
		<!-- jvectormap -->
		<script src="<?php echo base_url('public');?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="<?php echo base_url('public');?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
		<!-- jQuery Knob Chart -->
		<script src="<?php echo base_url('public');?>/plugins/knob/jquery.knob.js"></script>
		<!-- daterangepicker -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
		<script src="<?php echo base_url('public');?>/plugins/daterangepicker/daterangepicker.js"></script>
		<!-- datepicker -->
		<script src="<?php echo base_url('public');?>/plugins/datepicker/bootstrap-datepicker.js"></script>
		<!-- Bootstrap WYSIHTML5 -->
		<script src="<?php echo base_url('public');?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
		<!-- Slimscroll -->
		<script src="<?php echo base_url('public');?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
		<!-- FastClick -->
		<script src="<?php echo base_url('public');?>/plugins/fastclick/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="<?php echo base_url('public');?>/dist/js/app.js"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<!-- script src="<?php echo base_url('public');?>/dist/js/pages/dashboard.js"></script -->
		<!-- AdminLTE for demo purposes -->
		<script src="<?php echo base_url('public');?>/dist/js/demo.js"></script>		
		<!-- iCheck -->
		<script src="<?php echo base_url('public');?>/plugins/iCheck/icheck.min.js"></script>
		<script src="<?php echo base_url('public');?>/js/fa-loading.js"></script>
		<!-- main JS -->
		<script src="<?php echo base_url('public');?>/js/main.js"></script>
		<script>
		  $(function () {
			$('input').iCheck({
			  checkboxClass: 'icheckbox_square-blue',
			  radioClass: 'iradio_square-blue',
			  increaseArea: '20%' // optional
			});
		  });
		</script>
	</footer>
</html>