<?php get_header();?>
	<div class="container"  id="main">
		
		<div class="col-md-12">

			<!-- Post -->
			<article class="post">
				<header>
					<div class="title_404">
						
						<h2><?php echo esc_html__('404','core-news');?></h2>
					</div>
				</header>
				
				<div class="errorpage" id="primary">
	                <h3><i class="fa fa-exclamation-triangle"></i><?php echo esc_html__('Sorry! Page Not Found','core-news');?></h3>
	                <p>
	                    <?php echo esc_html__('Your searched terms not found please try another keyword.','core-news');?>
	                </p>
                    <div class="btn-group">
                        <a href="<?php echo esc_url(home_url());?>" class="button_404">
                            <?php echo esc_html__('Home Page','core-news');?>
                        </a>
                    </div>
                </div>
				
			</article>
		</div>
	</div>
<?php get_footer();?>