<div class="page-container">
<!-- Page content -->
	<div class="page-content">
		<!-- Main content-->
		<div class="content-wrapper">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="">
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">
								<i class="icon-drawer3"></i>
								Articles
							</h5>
							<div class="heading-elements">
								<button type="button" id="new_article" class="btn btn-primary" data-toggle="modal" data-target="#article_modal">
									Create New
									<i class="icon-plus2"></i>
								</button>
							</div>
						</div>
						
						<table id="table_data" class="table datatable-basic table-hover">
							<thead>
								<tr>
									<th>Title</th>
									<th>URL</th>
									<th>Date Created</th>
									<th>Date Updated</th>
									<th>Published</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($art_data AS $ad){ 
									$arr = (array)$ad
								?>
								<tr>
									<td>
										<a href="#" onClick="modify_article(<?php echo $arr['art_id'];?>)" data-toggle="modal" data-target="#article_modal">
										<?php echo $arr['art_title'];?>
										</a>
									</td>
									<td>
										<a href="<?php echo base_url().'article_controller/view_article/'.$arr['art_url'];?>">
										<?php echo base_url().'article_controller/view_article/'.$arr['art_url'];?>
										</a>
									</td>
									<td><?php echo $arr['date_created'];?></td>
									<td><?php echo $arr['date_updated'];?></td>
									<td>
										<i class="<?php echo (($arr['is_publish'] == 0) ? 'icon-check': '');?>"></i>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	<!-- Page content -->
	
	<!-- MODALS -->
	<div id="article_modal" class="modal fade" data-backdrop="static">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-slate">
					<button type="button" class="close" id = "close_hdr" data-dismiss="modal">&times;</button>
					<h6 class="modal-title"><i class=" icon-pencil7 position-left"></i>New Article </h6>
				</div>
			
				<form action="#" id="art_form">
					<div class="modal-body">
						<input type="hidden" id="art_id" name = "art_id"  class="clear_art">
						<div class="form-group">
							<div class="row">
								<label class="control-label col-lg-2">Title</label>
								<div class="col-lg-10">
									<input type="text" id="art_title" name="art_title" class="form-control required">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<label class="control-label col-lg-2">Content</label>
								<div class="col-lg-10">
									<textarea rows="5" cols="5" class="form-control required" id="art_content" name="art_content"  placeholder="Please write a content for your article"></textarea>
								</div>
							</div>
						</div>
						<!--form action="#" id="photo_form">
							<div class="form-group">
								<label class="col-lg-2 control-label text-semibold">Cover Photo: </label>
								<div class="col-lg-10">
									<input type="file" id="photo_items" name="photo_items" class="file-input" data-show-upload="false" data-show-caption="true">
								</div>
							</div>
						</form-->
					</div>
				</form>

				<div class="modal-footer">
					<button type="button" id="art_save" class="btn btn-success ">Save Draft</button>
					<button type="button" id="art_publish" class="btn btn-success sys-hide">Publish</button>
					<button type="button" id="art_upd" class="btn btn-warning sys-hide">Update</button>
					<button type="button" id="art_del" class="btn btn-danger sys-hide">Delete</button>
					<button type="button" class="btn btn-link" id = "close_ftr" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	
<script ="script/javascript">
	$(document).ready(function(){
		base_url = "<?php echo base_url();?>"; 
		// ## TABLE SETUP FOR DATATABLE
		$("#table_data").dataTable({
			autoWidth: false,
			columnDefs: [{ 
				orderable: false,
				width: '100px',
				targets: [ 4 ]
			}],
			dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
			language: {
				search: '<span>Filter:</span> _INPUT_',
				lengthMenu: '<span>Show:</span> _MENU_',
				paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
			},
			drawCallback: function () {
				$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
			},
			preDrawCallback: function() {
				$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
			}
		});
		
		 $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');
		 
		 $('.dataTables_length select').select2({
			minimumResultsForSearch: "-1"
		});
		
		
		// ## COVER PHOTO FIELD BOOTSTRAP SETUP
		$('.file-input').fileinput({
			browseLabel: '',
			browseClass: 'btn btn-primary btn-icon',
			removeLabel: '',
			uploadLabel: '',
			uploadClass: 'btn btn-default btn-icon',
			browseIcon: '<i class="icon-plus22"></i> ',
			uploadIcon: '<i class="icon-file-upload"></i> ',
			removeClass: 'btn btn-danger btn-icon',
			removeIcon: '<i class="icon-cancel-square"></i> ',
			layoutTemplates: {
				caption: '<div tabindex="-1" class="form-control file-caption {class}">\n' + '<span class="icon-file-plus kv-caption-icon"></span><div class="file-caption-name"></div>\n' + '</div>'
			},
			initialCaption: "No file selected",
			maxFileSize: 200
		});
		
		
		form = $( "#art_form" );
		form.validate({ 
			ignore: 'input[type=hidden]', // ignore hidden fields
			errorClass: 'validation-error-label',
			successClass: 'validation-valid-label',
			messages: {
				addInvoice: "This button is required."
			},
			highlight: function(element, errorClass) {
				$(element).removeClass(errorClass);
			},
			unhighlight: function(element, errorClass) {
				$(element).removeClass(errorClass);
			},

			validClass: "validation-valid-label",
			success: function(label,validClass) {
				 label.addClass(validClass);
				 label.remove();
			},
			errorElement: 'div',
			errorPlacement: function(error, element) {
				if(element.parent('.input-group').length) {
					error.insertAfter(element.parent());
				} else {
					error.insertAfter(element);
				}
			},
			onError : function(){
				$('.input-group.error-class').find('.help-block.form-error').each(function() {
				  $(this).closest('.input-group').addClass('error-class').append($(this));
				});
			},
		});
		
		$("#new_article").on('click', function(e){
			default_form('new');
		})
		
		// SAVING ARTICLE
		$("#art_save").on("click", function(e){
			if(form.valid()){
				$.ajax({
					url: base_url+'article_controller/save_article',
					type:'POST',
					data: $("#art_form").serialize(),
					dataType: 'json',
					beforeSend: function(){
						var block_title = '';
						block_loader(block_title);
					},
					error: function(xhr,err,opt){
						$.unblockUI();
						bootbox
							.alert('API error.')
							.on('hidden.bs.modal', function (e) {
								if($('.modal.in').css('display') == 'block'){
									$('body').addClass('modal-open');
								}
							});
					},
					success: function(oData){
						$.unblockUI();
						if(oData.status==1){
							location.reload(); 
						}
						else{
							bootbox
							.alert('Article not saved.')
							.on('hidden.bs.modal', function (e) {
								if($('.modal.in').css('display') == 'block'){
									$('body').addClass('modal-open');
								}
							});
						}
					},
					complete: function(){
						$.unblockUI();
					}
				});
			}
			else{
				bootbox
					.alert('Please check your inputs.')
					.on('hidden.bs.modal', function (e) {
						if($('.modal.in').css('display') == 'block'){
							$('body').addClass('modal-open');
						}
					});
			}
		});
		//update article
		$("#art_upd").on("click", function(e){
			if(form.valid()){
				$.ajax({
					url: base_url+'article_controller/upd_article',
					type:'POST',
					data: $("#art_form").serialize(),
					dataType: 'json',
					beforeSend: function(){
						var block_title = '';
						block_loader(block_title);
					},
					error: function(xhr,err,opt){
						$.unblockUI();
						bootbox
							.alert(xhr.responseText)
							.on('hidden.bs.modal', function (e) {
								if($('.modal.in').css('display') == 'block'){
									$('body').addClass('modal-open');
								}
							});
					},
					success: function(oData){
						$.unblockUI();
						if(oData.status==0){
							location.reload();
						}
						else{
							bootbox
							.alert(oData.msg)
							.on('hidden.bs.modal', function (e) {
								if($('.modal.in').css('display') == 'block'){
									$('body').addClass('modal-open');
								}
							});
						}
					},
					complete: function(){
						$.unblockUI();
					}
				});
			}
			else{
				bootbox
					.alert('Please check your inputs.')
					.on('hidden.bs.modal', function (e) {
						if($('.modal.in').css('display') == 'block'){
							$('body').addClass('modal-open');
						}
					});
			}
		});
		
		// delete article
		$("#art_del").on("click", function(e){
			if(form.valid()){
				$.ajax({
					url: base_url+'article_controller/del_article',
					type:'POST',
					data: $("#art_form").serialize(),
					dataType: 'json',
					beforeSend: function(){
						var block_title = '';
						block_loader(block_title);
					},
					error: function(xhr,err,opt){
						$.unblockUI();
						bootbox
							.alert(xhr.responseText)
							.on('hidden.bs.modal', function (e) {
								if($('.modal.in').css('display') == 'block'){
									$('body').addClass('modal-open');
								}
							});
					},
					success: function(oData){
						$.unblockUI();
						if(oData.status==0){
							location.reload();
						}
						else{
							bootbox
							.alert(oData.msg)
							.on('hidden.bs.modal', function (e) {
								if($('.modal.in').css('display') == 'block'){
									$('body').addClass('modal-open');
								}
							});
						}
					},
					complete: function(){
						$.unblockUI();
					}
				});
			}
			else{
				bootbox
					.alert('Please check your inputs.')
					.on('hidden.bs.modal', function (e) {
						if($('.modal.in').css('display') == 'block'){
							$('body').addClass('modal-open');
						}
					});
			}
		});
		
		// publish article
		$("#art_publish").on("click", function(e){
			if(form.valid()){
				$.ajax({
					url: base_url+'article_controller/publish_article',
					type:'POST',
					data: $("#art_form").serialize(),
					dataType: 'json',
					beforeSend: function(){
						var block_title = '';
						block_loader(block_title);
					},
					error: function(xhr,err,opt){
						$.unblockUI();
						bootbox
							.alert(xhr.responseText)
							.on('hidden.bs.modal', function (e) {
								if($('.modal.in').css('display') == 'block'){
									$('body').addClass('modal-open');
								}
							});
					},
					success: function(oData){
						$.unblockUI();
						if(oData.status==0){
							location.reload();
						}
						else{
							bootbox
							.alert(oData.msg)
							.on('hidden.bs.modal', function (e) {
								if($('.modal.in').css('display') == 'block'){
									$('body').addClass('modal-open');
								}
							});
						}
					},
					complete: function(){
						$.unblockUI();
					}
				});
			}
			else{
				bootbox
					.alert('Please check your inputs.')
					.on('hidden.bs.modal', function (e) {
						if($('.modal.in').css('display') == 'block'){
							$('body').addClass('modal-open');
						}
					});
			}
		});
	})
	
	function default_form(mode = 'new'){
		if(mode == 'new'){
			$("#art_save").removeClass('sys-hide');
			$("#art_publish").addClass('sys-hide');
			$("#art_upd").addClass('sys-hide');
			$("#art_del").addClass('sys-hide');
			
			$("#art_form input[type=text], #art_form input[type=hidden]").val('');
			$("#art_content").val('');
		}
		else{
			$("#art_save").addClass('sys-hide');
			$("#art_publish").removeClass('sys-hide');
			$("#art_upd").removeClass('sys-hide');
			$("#art_del").removeClass('sys-hide');
		}
	}
	
	
	function modify_article(id=0){
		$.ajax({
			url: base_url+'article_controller/modify_article',
			type:'POST',
			data: {id: id},
			dataType: 'json',
			beforeSend: function(){
				var block_title = '';
				block_loader(block_title);
			},
			error: function(xhr,err,opt){
				$.unblockUI();
				bootbox
					.alert(xhr.responseText)
					.on('hidden.bs.modal', function (e) {
						if($('.modal.in').css('display') == 'block'){
							$('body').addClass('modal-open');
						}
					});
			},
			success: function(oData){
				$.unblockUI();
				if(oData.status==0){
					eval(oData.eval);
					default_form('modify');
				}
				else{
					bootbox
					.alert(oData.msg)
					.on('hidden.bs.modal', function (e) {
						if($('.modal.in').css('display') == 'block'){
							$('body').addClass('modal-open');
						}
					});
				}
			},
			complete: function(){
				$.unblockUI();
			}
		});
	}
	
	function div_block_loader(div_id,msg){
		 $(div_id).block({
			message: '<i class="icon-spinner4 spinner"></i>'+msg,
			overlayCSS: {
				backgroundColor: '#fff',
				opacity: 0.8,
				cursor: 'wait'
			},
			css: {
				border: 0,
				padding: 0,
				backgroundColor: 'none'
			}
		});
	}
	
	function block_loader(title){
		$.blockUI({ 
			message: '<h4><i class="icon-spinner4 spinner"></i>&nbsp'+title+'</h4>',
			overlayCSS: {
				backgroundColor: '#1b2024',
				opacity: 0.8,
				cursor: 'wait'
			},
			css: {
				border: 0,
				color: '#fff',
				padding: 0,
				backgroundColor: 'transparent'
			}
		});
	}
</script>