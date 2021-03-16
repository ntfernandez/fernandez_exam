<div class="page-container">
<!-- Page content -->
	<div class="page-content">
		<!-- Main content-->
		<div class="content-wrapper">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="">
					<div class="panel panel-flat">
							<div class="panel-heading">
								<h6 class="panel-title">Latest Article</h6>
		                	<a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>

							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12">
										<ul class="media-list content-group">
											<li class="media stack-media-on-mobile">
			                					<div class="media-left col-md-3">
													<div class="thumb">
														<a href="#">
															<img src="<?echo base_url();?>assets/images/cover.jpg" class="img-responsive img-rounded media-preview" width="150px" >
														</a>
													</div>
												</div>

			                					<div class="media-body">
													<h6 class="media-heading"><a href="#"><?php echo $art_data['art_title'];?></a></h6>
						                    		<ul class="list-inline list-inline-separate text-muted mb-5">
						                    			<li><i class=" icon-pencil5 position-left"></i> <?php echo (($art_data['date_created'] !== $art_data['date_updated']) ? "Article Updated" : "Article Created");?></li>
						                    			<li><?php echo (($art_data['date_created'] !== $art_data['date_updated']) ? $art_data['date_updated'] : $art_data['date_created']);?></li>
						                    		</ul>
													<?php echo $art_data['art_content'];?>
												</div>
											</li>
										</ul>
									</div>

								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
		
	</div>
	<!-- Page content -->