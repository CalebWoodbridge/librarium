<?php
/*
Plugin Name: Librarium
Description: Easily manage and display collections of books.
Version:     20171022
Author:      Caleb Woodbridge
Author URI:  http://
Text Domain: librarium
License:     GPL3
*/


// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');

function my_acf_settings_path( $path ) {

    // update path
    $path = plugin_dir_path( __FILE__ ) . 'acf/';

    // return
    return $path;

}

// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');

function my_acf_settings_dir( $dir ) {

    // update path
    $dir = plugin_dir_url( __FILE__ ) . 'acf/';

    // return
    return $dir;

}


// 3. Include ACF
include_once( plugin_dir_path( __FILE__ ) . '/acf/acf.php' );

/**
 * Register Custom Post Types.
 */
function librarium_register_my_cpts() {

	/**
	 * Post Type: Books.
	 */

	$labels = array(
		"name" => __( 'Books', 'librarium' ),
		"singular_name" => __( 'Book', 'librarium' ),
		"menu_name" => __( 'Books', 'librarium' ),
		"all_items" => __( 'All Books', 'librarium' ),
		"add_new" => __( 'Add New', 'librarium' ),
		"add_new_item" => __( 'Add New Book', 'librarium' ),
		"edit_item" => __( 'Edit Book', 'librarium' ),
		"new_item" => __( 'New Book', 'librarium' ),
		"view_item" => __( 'View Book', 'librarium' ),
		"view_items" => __( 'View Books', 'librarium' ),
		"search_items" => __( 'Search Books', 'librarium' ),
		"not_found" => __( 'No Books found', 'librarium' ),
		"not_found_in_trash" => __( 'No Books found in Trash', 'librarium' ),
		"featured_image" => __( 'Cover Image', 'librarium' ),
		"set_featured_image" => __( 'Set Cover Image for this book', 'librarium' ),
		"remove_featured_image" => __( 'Remove Cover Image for this book', 'librarium' ),
		"use_featured_image" => __( 'Use as Cover Image for this book', 'librarium' ),
		"archives" => __( 'Book Archives', 'librarium' ),
		"insert_into_item" => __( 'Insert into page', 'librarium' ),
		"uploaded_to_this_item" => __( 'Uploaded to this page', 'librarium' ),
		"filter_items_list" => __( 'Filter Books list', 'librarium' ),
		"items_list_navigation" => __( 'Books list navigation', 'librarium' ),
		"items_list" => __( 'Books list', 'librarium' ),
		"attributes" => __( 'Book attributes', 'librarium' ),
	);

	$args = array(
		"label" => __( 'Books', 'librarium' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "books", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 20,
		"menu_icon" => "dashicons-book",
		"supports" => array( "title", "editor", "thumbnail", "excerpt", "custom-fields", "comments", "revisions" ),
	);

	register_post_type( "books", $args );

	/**
	 * Post Type: Shop links.
	 */

	$labels = array(
		"name" => __( 'Shop links', 'librarium' ),
		"singular_name" => __( 'Shop link', 'librarium' ),
	);

	$args = array(
		"label" => __( 'Shop links', 'librarium' ),
		"labels" => $labels,
		"description" => "Links to online shops to be displayed on Book product pages.",
		"public" => false,
		"publicly_queryable" => false,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "shops", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 20,
		"menu_icon" => "dashicons-cart",
		"supports" => array( "title" ),
	);

	register_post_type( "shops", $args );

}

add_action( 'init', 'librarium_register_my_cpts' );

/**
 * Register Taxonomies
 */

function librarium_register_my_taxes() {

	/**
	 * Taxonomy: Series.
	 */

	$labels = array(
		"name" => __( 'Series', 'librarium' ),
		"singular_name" => __( 'Series', 'librarium' ),
	);

	$args = array(
		"label" => __( 'Series', 'librarium' ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "Series",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'series', 'with_front' => true, ),
		"show_admin_column" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => true,
	);
	register_taxonomy( "series", array( "books" ), $args );

	/**
	 * Taxonomy: Editions
	 */

	$labels = array(
		"name" => __( 'Editions', 'librarium' ),
		"singular_name" => __( 'Edition', 'librarium' ),
	);

	$args = array(
		"label" => __( 'Editions', 'librarium' ),
		"labels" => $labels,
		"public" => false,
		"hierarchical" => true,
		"label" => "Edition",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => false,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'edition', 'with_front' => true, ),
		"show_admin_column" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => true,
	);
	register_taxonomy( "editions", array( "books", "shops" ), $args );

}

add_action( 'init', 'cptui_register_my_taxes' );


//Customise Series taxonomy archive display

function librarium_customise_series_display_order( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_tax('series') ) {
    $query->set('meta_key', 'series_number');
		$query->set('orderby', 'meta_value');
		$query->set('order', 'ASC');
	}
}
add_action( 'pre_get_posts', 'librarium_customise_series_display_order' );

/**
 * Register Custom Fields.
 */

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_book-details',
		'title' => 'Book Details',
		'fields' => array (
			array (
				'key' => 'field_series_number',
				'label' => 'Number in series',
				'name' => 'series_number',
				'type' => 'number',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'step' => '',
			),
			array (
				'key' => 'field_595e15baf990e',
				'label' => 'Print ISBN',
				'name' => 'book_isbn',
				'type' => 'number',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => 9780000000000,
				'max' => 9789999999999,
				'step' => '',
			),
			array (
				'key' => 'field_595e15baf990d',
				'label' => 'Ebook ISBN',
				'name' => 'ebook_isbn',
				'type' => 'number',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => 9780000000000,
				'max' => 9789999999999,
				'step' => '',
			),
			array (
				'key' => 'field_595e15d8f990f',
				'label' => 'Publisher',
				'name' => 'publisher',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_595e15d8f990g',
				'label' => 'Publisher website URL',
				'name' => 'publisher_url',
				'type' => 'text',
				'default_value' => '',
        'prepend' => 'http://',
				'placeholder' => 'www.yourpublisher.com',
			),
			array (
				'key' => 'cover_595e15d8f990f',
				'label' => 'Cover designer/illustrator',
				'name' => 'cover_artist',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'cover_url_595e15d8f990g',
				'label' => 'Cover designer/illustrator URL',
				'name' => 'cover_url',
				'type' => 'text',
        'prepend' => 'http://',
        'placeholder' => 'www.yourillustrator.com',
			),
			array (
				'key' => 'field_59774ba79f4ff',
				'label' => 'Publication date',
				'name' => 'pub_date',
				'type' => 'date_picker',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'display_format' => 'd/m/Y',
				'return_format' => 'F j, Y',
				'first_day' => 1,
			),
			array (
				'key' => 'field_595e1606f9911',
				'label' => 'Related titles',
				'name' => 'book_related_titles',
				'type' => 'post_object',
				'post_type' => array (
					0 => 'books',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'allow_null' => 1,
				'multiple' => 1,
			),
			array (
				'key' => 'field_595e163df9912',
				'label' => 'Page length',
				'name' => 'book_page_length',
				'type' => 'number',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_595e1689f9913',
				'label' => 'Sample',
				'name' => 'book_sample_content',
				'type' => 'file',
				'instructions' => 'Upload a book sample (e.g. PDF)',
				'save_format' => 'object',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'books',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

// Add Shop link fields

register_field_group(array (
	'key' => 'group_5981b34b36843',
	'title' => 'Shop link settings',
	'fields' => array (
		array (
			'key' => 'field_5981ac7b25520',
			'label' => 'Icon',
			'name' => 'icon',
			'type' => 'image',
			'instructions' => 'Shop icon - displayed at 48x48, upload a 96x96 image to look good on high-DPI (\'retina\') screens.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => 48,
			'min_height' => 48,
			'min_size' => '',
			'max_width' => 96,
			'max_height' => 96,
			'max_size' => '',
			'mime_types' => '',
		),
		array (
			'key' => 'field_5981ad3b25521',
			'label' => 'Link URL',
			'name' => 'url',
			'type' => 'text',
			'instructions' => 'The URL structure for the link, e.g. to a product page or search result. Use {isbn} or {title} as a placeholder.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
		array (
			'key' => 'field_5981ae7ff2088',
			'label' => 'Format',
			'name' => 'format',
			'type' => 'select',
			'instructions' => 'Print or ebook?',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'print' => 'Print',
				'ebook' => 'Ebook',
			),
			'default_value' => array (
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'ajax' => 0,
			'return_format' => 'value',
			'placeholder' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'shops',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
  ));

}


// Add the custom columns to the book post type:
add_filter( 'manage_books_posts_columns', 'librarium_set_custom_edit_books_columns' );

function librarium_set_custom_edit_books_columns($columns) {
		$columns = array(
			'cb'	 	=> '<input type="checkbox" />',
		  'thumbnail' 	=> __( 'Cover', 'librarium' ),
			'title' 	=> __( 'Title', 'librarium' ),
			'series'	=>	__( 'Series', 'librarium' ),
			'series_number'	=>	__( '#', 'librarium' ),
			'pub_date'	=>	__( 'Publication date', 'librarium' ),
			'publisher'	=>	__( 'Publisher', 'librarium' ),
			'editions'	=>	__( 'Edition', 'librarium' ),
		);
		return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_books_posts_custom_column' , 'librarium_custom_books_column', 10, 2 );
function librarium_custom_books_column( $column, $post_id ) {
	switch ( $column ) {
			case 'thumbnail' :
					echo get_the_post_thumbnail( $post_id, 'thumbnail' );
					break;
			case 'series' :
					$terms = get_the_term_list( $post_id, 'series', '', ',', '' );
					if ( is_string( $terms ) ) {
						echo $terms;
					}
					break;
			case 'series_number' :
					echo get_field( 'series_number', $post_id );
					break;
			case 'pub_date' :
					echo get_field( 'pub_date', $post_id );
					break;
			case 'publisher' :
					echo get_field( 'publisher', $post_id );
					break;
			case 'editions' :
					$terms = get_the_term_list( $post_id, 'editions', '', ',', '' );
					if ( is_string( $terms ) ) {
						echo $terms;
					}
					break;
	}
}

// Add the custom columns to the shop post type:
add_filter( 'manage_shops_posts_columns', 'librarium_set_custom_edit_shops_columns' );

function librarium_set_custom_edit_shops_columns($columns) {
		$columns = array(
			'cb'	 	=> '<input type="checkbox" />',
			'title' 	=> __( 'Title', 'librarium' ),
			'icon' 	=> __( 'Icon', 'librarium' ),
		  'url' 	=> __( 'Link URL', 'librarium' ),
			'format'	=>	__( 'Format', 'librarium' ),
			'editions'	=>	__( 'Edition', 'librarium' ),
		);
		return $columns;
}

// Add the data to the custom columns for the shop post type:
add_action( 'manage_shops_posts_custom_column' , 'librarium_custom_shops_column', 10, 2 );
function librarium_custom_shops_column( $column, $post_id ) {
	switch ( $column ) {
			case 'icon' :
					$image = get_field('icon');
					echo '<img src="'.$image["url"]. '" size="48" width="48" alt="'.get_the_title(get_field($post_id)).'" />';
					break;
			case 'url' :
					echo get_field( 'url', $post_id );
					break;
			case 'format' :
					$format = get_field( 'format', $post_id );
					echo $format;
					break;
			case 'editions' :
					$terms = get_the_term_list( $post_id, 'editions', '', ',', '' );
					if ( is_string( $terms ) ) {
						echo $terms;
					}
					break;
	}
}


function librarium_get_book_meta( $book_id ){
   $book = array (
     'title'          => get_the_title($book_id),
     'sample' 				=> get_field('book_sample_content', $book_id),
     'book_isbn'  		=> get_field('book_isbn', $book_id),
     'ebook_isbn'			=> get_field('ebook_isbn', $book_id),
     'pub_date'  		  => get_field('pub_date', $book_id),
     'publisher'  		=> get_field('publisher', $book_id),
     'publisher_url' 	=> get_field('publisher_url', $book_id),
     'cover_artist' 	=> get_field('cover_artist', $book_id),
     'cover_url' 			=> get_field('cover_url', $book_id),
   );
   return $book;
}

function librarium_get_shop_links( $book_id ){
  // get which regions this book is in
  $in_regions = get_the_terms( $book_id, 'regions');

  if (is_array($in_regions) ) :

    // pull out the edition ids into an array
    $regions_ids = array();
    foreach ( $in_regions as $edition) {
       $regions_ids[] = $edition->term_id;
    }

    // get shops that match the book edition, sorted by format
    $args = array(
     'post_type' => 'shops',
     'tax_query' => array(
         array (
             'taxonomy' => 'regions',
             'field' => 'term_id',
             'terms' => $regions_ids,
         )
     ),
     'meta_key' => 'format',
     'orderby'	=> 'meta_value_num',
     'order'		=> 'ASC',
    );

    $shops_links = new WP_Query($args);
    wp_reset_postdata();
  endif;

  return $shops_links;
}


// Hide ACF field group menu item
add_filter('acf/settings/show_admin', '__return_false');
function remove_acf(){
  remove_menu_page( 'edit.php?post_type=acf' );
}
add_action( 'admin_menu', 'remove_acf',100 );
