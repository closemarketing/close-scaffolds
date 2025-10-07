<?php
/**
 * CPT Testimonios
 *
 * @package    WordPress
 * @author     Manuel Muñoz <manolo@close.marketing>
 * @copyright  2022 Closemarketing
 * @version    1.0
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'cmkmn_cpt_testimonio' );
/**
 * Register Post Type POST Testimonios
 *
 * @return void
 **/
function cmkmn_cpt_testimonio() {
	$labels = array(
		'name'               => __( 'Testimonios', 'mentoringnegocios' ),
		'singular_name'      => __( 'Testimonio', 'mentoringnegocios' ),
		'add_new'            => __( 'Añadir nuevo Testimonio', 'mentoringnegocios' ),
		'add_new_item'       => __( 'Añadir nuevo Testimonio', 'mentoringnegocios' ),
		'edit_item'          => __( 'Editar Testimonio', 'mentoringnegocios' ),
		'new_item'           => __( 'Nuevo Testimonio', 'mentoringnegocios' ),
		'view_item'          => __( 'Ver Testimonio', 'mentoringnegocios' ),
		'search_items'       => __( 'Buscar Testimonios', 'mentoringnegocios' ),
		'not_found'          => __( 'No se han encontrado Testimonios', 'mentoringnegocios' ),
		'not_found_in_trash' => __( 'No se han encontrado Testimonios en la papelera', 'mentoringnegocios' ),
	);
	$args   = array(
		
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_rest'       => true, // Adds gutenberg support.
		'query_var'          => true,
		'has_archive'        => true,
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'menu_position'      => 7,
		'menu_icon'          => 'dashicons-book',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
	);
	register_post_type( 'testimonio', $args );
}

add_filter( 'rwmb_meta_boxes', 'cmk_register_meta_boxes_tes' );
/**
 * Adds Metabox Function
 * Needs MetaBox to work: https://www.closemarketing.es/go/metabox/
 *
 * @param array $meta_boxes Metaboxes.
 * @return array $metaboxes
 */
function cmk_register_meta_boxes_tes( $meta_boxes ) {
	$prefix = 'tes_';

	// 2nd meta box
	$meta_boxes[] = array(
		'id'         => 'standard-testimonios',
		'title'      => __( 'Opciones testimonios', 'mentoringnegocios' ),
		'post_types' => array( 'testimonio' ),
		'context'    => 'normal', // side / normal. 
		'priority'   => 'high',
		'autosave'   => true,
		'fields'     => array(
			// URL.
			array(
				'name' 		=> __( 'Web', 'mentoringnegocios' ),
				'id'			=> "{$prefix}web",
				'desc' 		=> '',
				'type' 		=> 'url',
				'std'  		=> '',
			),
			// Oembed
			array(
				'id'    => "{$prefix}video",
				'name'  => __( 'Vídeo opinión', 'mentoringnegocios' ),
				'type'  => 'oembed',
				'size'  => 30,
			),
			// TEXT.
			array(
				'name'              => __( 'Cargo', 'mentoringnegocios' ),
				'label_description' => __( 'Cargo en empresa', 'mentoringnegocios' ),
				'id'                => "{$prefix}cargo",
				'type'              => 'text',
				'std'               => '',
				'clone'             => false,
			),
		), // fields.
		
	);

	return $meta_boxes;
}

