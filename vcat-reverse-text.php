<?php 
/*
Plugin Name: VCAT Reverse Text
Plugin URI: http://www.vcat.de/edulabs/projekte/wordpress/reverse-text/
Description: Dieses Plugin dreht Text um :)
Version: 0.0.2
Author: VCAT Consulting GmbH (Nico Danneberg)
Author URI: http://www.vcat.de
*/

function vrt_save_post( $post_id ) {

	$title = get_the_title( $post_id );
	
	add_post_meta( $post_id, "vcat_reverse_title", strrev( $title ), true );
}
add_action( 'save_post', 'vrt_save_post' );


function vrt_reverse_title( $title, $id = null ) {

    return ( is_admin() ) ? $title : strrev( $title );
}
add_filter( 'the_title', 'vrt_reverse_title' );


function vrt_reverse_shortcode( $atts, $content = "" ) {
	$atts = shortcode_atts( array( 'bold' => false ), $atts, 'reverse' );
	
	if( $atts[ 'bold' ] ) {
		return "<strong>" . strrev( $content ) . "</strong>";	
	} else {
		return strrev( $content );
	}
}
add_shortcode( 'reverse', 'vrt_reverse_shortcode' );

if( is_admin() ) {
	add_action( 'admin_head', 'vrt_admin_head' );
	// enqueue other scripts and styles
}

function vrt_admin_head() {
	if( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}

	if( get_user_option( 'rich_editing' ) == 'true' ) {
		add_filter( 'mce_external_plugins', 'vrt_mce_external_plugins' );
		add_filter( 'mce_buttons', 'vrt_mce_buttons' );
	}
}

function vrt_mce_external_plugins( $plugin_array ) {
	$plugin_array[ 'vrtmce' ] = plugins_url( 'js/vrt-mce-button.js' , __FILE__ );
	return $plugin_array;
}

function vrt_mce_buttons( $buttons ) {
	array_push( $buttons, 'vrtbtn1' );
	return $buttons;
}

?>