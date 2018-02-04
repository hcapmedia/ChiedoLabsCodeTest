<?php
/**
 * Displays content for front page
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class( 'twentyseventeen-panel ' ); ?> >

	<?php if ( has_post_thumbnail() ) :
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'twentyseventeen-featured-image' );

		// Calculate aspect ratio: h / w * 100%.
		$ratio = $thumbnail[2] / $thumbnail[1] * 100;
		?>

		<div class="panel-image" style="background-image: url(<?php echo esc_url( $thumbnail[0] ); ?>);">
			<div class="panel-image-prop" style="padding-top: <?php echo esc_attr( $ratio ); ?>%"></div>
		</div><!-- .panel-image -->

	<?php endif; ?>

	<div class="panel-content">
		<div class="wrap">
			<header class="entry-header">
				<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

				<?php twentyseventeen_edit_link( get_the_ID() ); ?>

			</header><!-- .entry-header -->

			<div class="entry-content">



				<!--
					dRich CUSTOM CODE START
				-->

				<?php
					$one_ago_int = 0; /* last two gray rgb values stored for comparison */
					$two_ago_int = 0;

					$query = new WP_Query( 'cat=2' ); /* WP loop filters on cat ID 2, "test" category of posts */
					if ( $query->have_posts() ) : 
						while ( $query->have_posts() ) : $query->the_post();

							/* generate random int to create a gray rgb value used as background-color for each post div */
							$gray_int = 0;
							do {
								$gray_int = rand(165,225);
							}
							while (abs($one_ago_int - $gray_int) <= 15 || abs($two_ago_int - $gray_int) <= 15);  /* test value against last two values */

							$two_ago_int = $one_ago_int;
							$one_ago_int = $gray_int;
				?>
							<!-- front-page-tri-column defined in "Additional CSS" -->
							<div class="front-page-tri-column" style="background-color: rgb(<?php echo $gray_int ?>,<?php echo $gray_int ?>,<?php echo $gray_int ?>)">

							<!-- Display the Title as a link to the Post's permalink. -->
							<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

							<!-- Display the date (November 16th, 2009 format) and a link to other posts by this posts author. -->
							<small><?php the_time( 'F jS, Y' ); ?> by <?php the_author_posts_link(); ?></small>

							<div class="entry">
								<?php the_content(); ?>
							</div>

							<p class="postmetadata"><?php esc_html_e( 'Posted in' ); ?> <?php the_category( ', ' ); ?></p>
						</div> <!-- closes the first div box -->
			   
					<?php endwhile; 
					wp_reset_postdata();
				else : ?>
				<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
				<?php endif; ?>

				<!--
					dRich CUSTOM CODE END 
				-->



				<?php
					/* translators: %s: Name of current post */
					the_content( sprintf(
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
						get_the_title()
					) );
				?>
			</div><!-- .entry-content -->

		</div><!-- .wrap -->
	</div><!-- .panel-content -->

</article><!-- #post-## -->
