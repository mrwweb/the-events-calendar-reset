<?php
/*
Plugin Name: The Events Calendar Customizations
Description: An assortment of changes to how The Events Calendar behaves. You are encouraged to delete, add, and revise this file to meet your needs!
Version: 2.1.0
Author: Mark Root-Wiley, MRW Web Design
Author URI: https://MRWweb.com
Plugin URI: https://github.com/mrwweb/the-events-calendar-reset
*/

namespace MRW\TEC;

/**
 * Useful helper function to detect Tribe Events pages in your theme
 *
 * Modified slightly from the link
 *
 * Usage: \MRW\TEC\is_tribe_view()
 *
 * @link https://gist.github.com/samkent/b98bd3c9b28426b8461bc1417adf7b5d
 */
function is_tribe_view() {
	return
		(
			function_exists( 'tribe_is_event' ) &&
			tribe_is_event()
		) ||
		(
			function_exists( 'tribe_is_event_category' ) &&
			tribe_is_event_category()
		) ||
		(
			function_exists( 'tribe_is_in_main_loop' ) &&
			tribe_is_in_main_loop()
		) ||
		(
			function_exists( 'tec_is_view' ) &&
			tec_is_view()
		) ||
		'tribe_events' === get_post_type() ||
		is_singular( 'tribe_events' );
}

/**
 * Replace the wrapping <section> element surrounding all output with a <div>
 */
add_filter( 'tribe_events_views_v2_bootstrap_html', __NAMESPACE__ . '\replace_section_with_div' );
function replace_section_with_div( $html ) {
	return str_replace( '<section', '<div', str_replace( '</section>', '</div>', $html ) );
}

add_filter( 'tribe_get_organizer_website_link_label', __NAMESPACE__ . '\return_organizer_name', 99 );
/**
 * Use Organizer name for Event Organizer Website Link
 */
function return_organizer_name() {
	return tribe_get_organizer();
}

add_filter( 'register_tribe_events_post_type_args', __NAMESPACE__ . '\no_tags_on_events' );
/**
 * Remove post_tag from tribe_events post_type
 */
function no_tags_on_events( $args ) {
    $args['taxonomies'] = [];

    return $args;
}

add_action( 'pre_get_posts', __NAMESPACE__ . '\no_events_in_tag_archives' );
/**
 * Exclude tribe_events posts from tag archives
 */
function no_events_in_tag_archives( $query ) {
	if( ! is_admin() && ! $query->is_main_query() ) {
		return;
	}

	if( is_tag() ) {
		$query->set( 'post_type', [ 'post' ] );
	}
}

add_filter( 'tribe_events_editor_default_template', __NAMESPACE__ . '\default_blocks', 11 );
/**
 * Change default blocks when creating a new event with the Block Editor
 *
 * @see https://support.theeventscalendar.com/807454-Change-the-Default-Event-Template-in-Block-Editor
 */
function default_blocks( $template ) {
	$template = [
		[ 'tribe/event-datetime' ],
		[ 'core/paragraph', [ 
			'placeholder' => __( 'Add Description…', 'the-events-calendar' ), 
		], ],
		[ 'tribe/event-website' ],
		[ 'tribe/event-venue' ],
	];
	return $template;
}

// hide "Recent Past Events" when there are no upcoming events
add_filter( 'tribe_events_views_v2_show_latest_past_events_view', '__return_false' );

// List View
add_filter( 'tribe_events_views_v2_view_list_template_vars', __NAMESPACE__ . '\tribe_past_reverse_chronological_v2', 100 );
// Photo View
add_filter( 'tribe_events_views_v2_view_photo_template_vars', __NAMESPACE__ . '\tribe_past_reverse_chronological_v2', 100 );
/**
 * Changes Past Event to Reverse Chronological Order
 *
 * @param array $template_vars An array of variables used to display the current view.
 *
 * @return array Same as above. 
 */
function tribe_past_reverse_chronological_v2( $template_vars ) {
	if ( ! empty( $template_vars['is_past'] ) ) {
		$template_vars['events'] = array_reverse( $template_vars['events'] );
	}

	return $template_vars;
}

add_filter( 'get_the_archive_title', __NAMESPACE__ . '\archive_title' );
/**
 * Change "Events" to "Upcoming Events"/"Past Events" for List/Month/Day page
 *
 * Known issue: does not work with AJAX page. Reverts to "Events"
 */
function archive_title( $title ) {
    if( 'tribe_events' === get_post_type() ) {

        if( tribe_is_past() || ( $_GET['eventDisplay'] ?? '' ) === 'past' ) {
            $title = 'Past Events';
        } elseif ( tribe_is_upcoming() ) {
			$title = 'Upcoming Events';
		} else {
			$title = "Events";
        }

    }

    return $title;
}

add_action( 'tribe_template_after_include:events/v2/components/before', __NAMESPACE__ . '\events_archive_header', 9 );
/**
 * Add Title to Event Archive Pages
 *
 * Use Post Type Archive Descriptions plugin to edit archive description
 * https://wordpress.org/plugins/post-type-archive-descriptions/
 */
function events_archive_header() {
    the_archive_title( '<h1 class="archive-title page-title">', '</h1>' );
}

/**
 * Remove "Events" menu from WordPress admin bar
 *
 * @see https://theeventscalendar.com/knowledgebase/k/remove-events-from-the-wordpress-admin-bar/
 */
define( 'TRIBE_DISABLE_TOOLBAR_ITEMS', true );