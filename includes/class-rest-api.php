<?php
if (!defined('ABSPATH')) exit;

class SamiDataManager_REST_API {
    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {
        // Get all entries
        register_rest_route('custom-data-manager/v1', '/entries', [
            'methods' => 'GET',
            'callback' => [$this, 'get_entries'],
            'permission_callback' => [$this, 'check_permissions'],
        ]);

        // Get single entry
        register_rest_route('custom-data-manager/v1', '/entries/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => [$this, 'get_entry'],
            'permission_callback' => [$this, 'check_permissions'],
        ]);

        // Create entry
        register_rest_route('custom-data-manager/v1', '/entries', [
            'methods' => 'POST',
            'callback' => [$this, 'create_entry'],
            'permission_callback' => [$this, 'check_permissions'],
        ]);

        // Update entry
        register_rest_route('custom-data-manager/v1', '/entries/(?P<id>\d+)', [
            'methods' => 'PUT',
            'callback' => [$this, 'update_entry'],
            'permission_callback' => [$this, 'check_permissions'],
        ]);

        // Delete entry
        register_rest_route('custom-data-manager/v1', '/entries/(?P<id>\d+)', [
            'methods' => 'DELETE',
            'callback' => [$this, 'delete_entry'],
            'permission_callback' => [$this, 'check_permissions'],
        ]);
    }

    // Permission check (Admin or Editor)
    public function check_permissions($request) {
        return current_user_can('edit_posts');
    }

    // CRUD Methods
    public function get_entries($request) {
        $args = [
            'post_type' => 'custom_data',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];
        $entries = get_posts($args);
        return new WP_REST_Response($entries, 200);
    }

    public function get_entry($request) {
        $id = $request['id'];
        $entry = get_post($id);
        if (!$entry) {
            return new WP_Error('not_found', 'Entry not found', ['status' => 404]);
        }
        return new WP_REST_Response($entry, 200);
    }

    public function create_entry($request) {
        $data = $request->get_json_params();
        $title = sanitize_text_field($data['title']);
        $content = wp_kses_post($data['content']);

        $post_id = wp_insert_post([
            'post_type' => 'custom_data',
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => 'publish',
        ]);

        if (is_wp_error($post_id)) {
            return new WP_Error('creation_failed', 'Failed to create entry', ['status' => 400]);
        }

        return new WP_REST_Response(['id' => $post_id], 201);
    }

    public function update_entry($request) {
        $id = $request['id'];
        $data = $request->get_json_params();
        $title = sanitize_text_field($data['title']);
        $content = wp_kses_post($data['content']);

        $updated = wp_update_post([
            'ID' => $id,
            'post_title' => $title,
            'post_content' => $content,
        ]);

        if (is_wp_error($updated)) {
            return new WP_Error('update_failed', 'Failed to update entry', ['status' => 400]);
        }

        return new WP_REST_Response(['success' => true], 200);
    }

    public function delete_entry($request) {
        $id = $request['id'];
        $deleted = wp_delete_post($id, true);

        if (!$deleted) {
            return new WP_Error('delete_failed', 'Failed to delete entry', ['status' => 400]);
        }

        return new WP_REST_Response(['success' => true], 200);
    }
}