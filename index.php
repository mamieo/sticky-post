<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Pagination
 */

get_header();
pagination();

?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

	<?php
	$sticky = get_option( 'sticky_posts' );
	$args = array(
		'posts_per_page'      => 1,
		'post__in'            => $sticky,
		'ignore_sticky_posts' => 1
	);
	query_posts( $args );
	if ( $sticky[0] ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_type() );
	}
	wp_reset_query();

	if ( have_posts() ) :
		if ( is_home() && ! is_front_page() ) :
			?>
			<header>
				<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
			</header>
			<?php
		endif;

		/* Start the Loop */
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', get_post_type() );
		endwhile;

	else :
		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
