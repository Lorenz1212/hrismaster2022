<?php 
if($this->session->userdata('adminview')){
	$page_view = 'admin/view/'.$this->session->userdata('adminview');
}else{
	$page_view = 'admin/view/dashboard';
}
$this->load->view('admin/layouts/header'); 
$this->load->view('admin/layouts/navbar'); 
?>
<!--begin::Content-->

		<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
			
				<?php $this->load->view($page_view);?>
		</div>
<!--end::Content-->
<div id="TopupModal" class="modal modal-2">
  <span class="close close-2">&times;</span>
  <img class="modal-content modal-content-2" id="img01">
  <div id="caption"></div>
</div>
		<?php 
		$this->load->view('admin/layouts/footer');
		$this->load->view('script/adminscript'); 
		?>
	</body>
</html>