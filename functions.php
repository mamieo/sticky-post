<?php
/**
 * Pagination functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Pagination
 */

if ( ! function_exists( 'pagination_setup' ) ) :
	function pagination_setup() {
		load_theme_textdomain( 'pagination', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'pagination' ),
		) );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'custom-background', apply_filters( 'pagination_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'pagination_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pagination_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pagination_content_width', 640 );
}
add_action( 'after_setup_theme', 'pagination_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pagination_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'pagination' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'pagination' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'pagination_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function pagination_scripts() {
	wp_enqueue_style( 'pagination-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pagination_scripts' );


require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';



/**
 * Paginations
 */
function pagination( $pages = '', $range = 3 ) {
	$showitems = ( $range * 2 ) + 1;

	# page are currently viewing.
	global $paged;

	if ( empty( $paged ) ) {
		$paged = 1;
	}

	if ( $pages == '' ) {
		global $wp_query;

		$pages = $wp_query->max_num_pages;
		if ( ! $pages ) {
			$pages = 1;
		}
	}

	if ( 1 != $pages ) {
		echo '<div class="text-center">';
		echo '<ul class="pagination">';

		# show the first page
		if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
			echo '<li><a href="' . get_pagenum_link( 1 ) . '">&laquo;</a></li>';
		}
		# show the previous page
		if ( $paged > 1 && $showitems < $pages ) {
			echo '<li><a href="' . get_pagenum_link( $paged - 1 ) . '">&lsaquo;</a></li>';
		}
		for ( $i = 1; $i <= $pages; $i++ ) {
			if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
				echo ( $paged == $i ) ? '<li class="active"><span>' . $i . '</span></li>' : '<li><a href="' . get_pagenum_link( $i ) . '">' . $i . '</a></li>';
			}
		}
		# show the next page
		if ( $paged < $pages && $showitems < $pages ) {
			echo '<li><a href="' . get_pagenum_link( $paged + 1 ) . '">&rsaquo;</a></li>';
		}
		# show the last page
		if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) {
			echo '<li><a href="' . get_pagenum_link( $pages ) . '">&raquo;</a></li>';
		}
		echo '</ul>';
		echo '</div>';
	}
}

