<?php
/**
 * Plugin Name: WP HousePlan
 * Version: 1.0.0
 * Description: A WordPress plugin to display house plan.
 * Author: Dmytro Karpovych
 * Text Domain: wphouseplan
 * Domain Path: /languages/
 * License: MIT
 */


if (!function_exists('wp_house_plan_tax')) {
    function wp_house_plan_tax()
    {
        $args = array(
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
        );
        register_taxonomy('house', array('wphouseplan'), $args);
    }

    add_action('init', 'wp_house_plan_tax', 0);
}


if (!function_exists('wphouseplan_houseplan_cpt')) {

    function wphouseplan_houseplan_cpt()
    {

        $labels = array(
            'name' => _x('House Plans', 'Post Type General Name', 'wphouseplan'),
            'singular_name' => _x('House Plan', 'Post Type Singular Name', 'wphouseplan'),
            'menu_name' => __('House Plans', 'wphouseplan'),
            'name_admin_bar' => __('House Plans', 'wphouseplan'),
            'parent_item_colon' => __('Parent House Plan:', 'wphouseplan'),
            'all_items' => __('All House Plans', 'wphouseplan'),
            'add_new_item' => __('Add New House Plan', 'wphouseplan'),
            'add_new' => __('Add New', 'wphouseplan'),
            'new_item' => __('New House Plan', 'wphouseplan'),
            'edit_item' => __('Edit House Plan', 'wphouseplan'),
            'update_item' => __('Update House Plan', 'wphouseplan'),
            'view_item' => __('View House Plan', 'wphouseplan'),
            'search_items' => __('Search House Plan', 'wphouseplan'),
            'not_found' => __('No House Plan Found', 'wphouseplan'),
            'not_found_in_trash' => __('No House Plan Found in Trash', 'wphouseplan'),
        );
        $args = array(
            'label' => __('wphouseplan', 'wphouseplan'),
            'description' => __('Add houseplan to your website.', 'wphouseplan'),
            'labels' => $labels,
            'supports' => array('title', 'trackbacks', 'revisions',),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-images-alt2',
            'register_meta_box_cb' => 'wphouseplan_add_metaboxes',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'page',
        );
        register_post_type('wphouseplan', $args);

    }

    add_action('init', 'wphouseplan_houseplan_cpt', 0);

}
