<?php
/**
 * CPT Empresas
 *
 * @package    WordPress
 * @author     Angie Mulero <angie@close.marketing>
 * @copyright  2022 Closemarketing
 * @version    1.0
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'cmkmn_cpt_empresa' );
/**
 * Register Post Type POST Empresas
 *
 * @return void
 **/
function cmkmn_cpt_empresa() {
	$labels = array(
		'name'               => __( 'Empresas', 'mentoringnegocios' ),
		'singular_name'      => __( 'Empresa', 'mentoringnegocios' ),
		'add_new'            => __( 'Añadir Nueva Empresa', 'mentoringnegocios' ),
		'add_new_item'       => __( 'Añadir Nueva Empresa', 'mentoringnegocios' ),
		'edit_item'          => __( 'Editar Empresa', 'mentoringnegocios' ),
		'new_item'           => __( 'Nueva Empresa', 'mentoringnegocios' ),
		'view_item'          => __( 'Ver Empresa', 'mentoringnegocios' ),
		'search_items'       => __( 'Buscar Empresas', 'mentoringnegocios' ),
		'not_found'          => __( 'No se han encontrado Empresas', 'mentoringnegocios' ),
		'not_found_in_trash' => __( 'No se han encontrado Empresas en la papelera', 'mentoringnegocios' ),
	);
	$args   = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_rest'       => true, // Adds gutenberg support.
		'query_var'          => true,
		'rewrite'            => false,
		'has_archive'        => false,
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'menu_position'      => 8,
		'menu_icon'          => 'dashicons-admin-site-alt2', // https://developer.wordpress.org/resource/dashicons/.
		'supports'           => array( 'title', 'thumbnail', 'excerpt', 'revisions' ),
	);
	register_post_type( 'empresa', $args );
}
