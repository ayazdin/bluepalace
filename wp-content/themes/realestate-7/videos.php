
<?php 
global $ct_options;
global $paged;
$paged = ct_currentPage();
?>
<?php wp_enqueue_style( 'slider', get_template_directory_uri() . '/css/fancybox/jquery.fancybox.css',true,'1.1','all');?>
<?php wp_enqueue_script( 'script', get_template_directory_uri() . '/css/fancybox/jquery.fancybox.js', array ( 'jquery' ), 1.1, true);?>
<?php wp_enqueue_script( 'mediaScript', get_template_directory_uri() . '/css/fancybox/helpers/jquery.fancybox-media.js', array ( 'jquery' ), 1.1, true);?>

<div class="video">
	<?php 
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	$args = array(
		'posts_per_page' => 6,
		'post_type' => 'post',
		'category_name' => 'videos',
		'order' => 'desc',
		'paged' => $paged
		);
	query_posts($args);
	?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php 
		$videoLink = get_the_content();
		$imageForVideo = explode("=",$videoLink);
		?>
		<div class="vid_wrap">
			<a class="fancybox-media" href="<?php echo get_the_content();?>" title="<?php the_title();?>">
				<img src="http://i.ytimg.com/vi/<?php echo $imageForVideo[1];?>/hqdefault.jpg" alt="Tchaikovsky- Romance in F minor" align="top"/>
				<h5 style="text-align: center;"><?php echo the_title();?></h5>
			</a>

		</div>
	<?php endwhile; ?>
	<?php ct_numeric_pagination(); ?>

	<div class="clear"></div>

<?php else : ?>

	<div class="col span_12 row no-listings">
		<h4 class="marB20"><?php esc_html_e('Comming Soon...', 'contempo'); ?></h4>
	</div>

<?php endif; wp_reset_postdata(); ?>
</div>