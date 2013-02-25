<!-- BOTTOM LEFT FIVE CATEGORY LISTINGS -->
<?php function catch_that_image($post) {
/* Custom Code to fetch first image from the post */
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
    $first_img = "/images/default.jpg";
  }
  return $first_img;
} ?>  

<?php
// enter the IDs of the categories to display
$display_categories = array(10,7,8,5,6);//$display_categories = array(10, 8, 5, 7);
foreach ($display_categories as $category) { ?>
<div class="column span-4 colborder">
<div class="five_posts">
      <?php query_posts("showposts=1&cat=$category");
	    $wp_query->is_category = false;
		$wp_query->is_archive = false;
		$wp_query->is_home = true;
		 ?>
      <div class="cat_name"><h3><a href="<?php echo get_category_link($category);?>"><?php echo get_category($category)->name; //single_cat_title(); ?> &raquo;</a></h3></div>

      <?php while (have_posts()) : the_post(); ?>

		<?php

				$temp_args2 = array(
				'order'          => 'ASC',
				'orderby'        => 'menu_order',
				'post_type'      => 'attachment',
				'post_parent'    => $post->ID,
				'post_mime_type' => 'thumbnail',
				'post_status'    => null,
				'numberposts'    => 1,
				);
				$attachments = get_posts($temp_args2);
				if ($attachments) {
					foreach ($attachments as $attachment) {
						echo wp_get_attachment_link($attachment->ID, 'thumbnail', true, false);
					}
				}
		  ?>
		<?php // $image_custom = catch_that_image($post->ID) 
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

		?>
		<div class="cat_image"> <a href="<?php the_permalink() ?>" ><img width="150" height="100" src="<?php echo $feat_image; ?>"  class="catwise-img"></a></div>
		<div class="cat_bundle">
		<div class="cat_title"><h6><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h6></div>
		<div class="cat_data"> <div class="excerpt_small">
		<?php 
		$content = get_post_field('post_content', $post->ID); 
		$content = strip_tags($content);
		if (strlen($content) > 100) {

            // truncate string
            $stringCut = substr($content, 0, 100);

            // make sure it ends in a word so assassinate doesn't become ass...
            $content = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
        }
        echo $content;
		?>
		</div></div>
        <div class="meta"><?php /*<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read</a> | */?><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></div>
		</div>
		<div class="cat_sharethis" ><?php /*Uncomment to enable share plugin */  /* echo do_shortcode('[sharethis]');*/ ?></div>
	  <?php endwhile; ?>
    </div>
</div>
    <?php } ?>