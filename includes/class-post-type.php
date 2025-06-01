<?php
if (!defined('ABSPATH')) exit;

class SamiDataManager_Post_Type {
    public function __construct() {
        add_action('init', [$this, 'register_post_type']);
    }

    public function register_post_type() {
        $labels = array(
            'name' => 'Custom Data',
            'singular_name' => 'Custom Data Entry',
            'menu_name' => 'Custom Data Manager',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Entry',
            'edit_item' => 'Edit Entry',
            'new_item' => 'New Entry',
            'view_item' => 'View Entry',
            'search_items' => 'Search Entries',
            'not_found' => 'No entries found',
            'not_found_in_trash' => 'No entries found in Trash',
        );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'capability_type' => 'post',
            'supports' => array('title', 'editor', 'custom-fields'),
            'has_archive' => false,
            'rewrite' => false,
            'show_in_rest' => true, // Enable REST API
        );

        register_post_type('custom_data', $args);
    }
}