<?php
if (!defined('ABSPATH')) exit;

class SamiDataManager_Validation {
    public static function sanitize_entry_data($data) {
        $sanitized = [];
        $sanitized['title'] = sanitize_text_field($data['title']);
        $sanitized['content'] = wp_kses_post($data['content']);
        return $sanitized;
    }

    public static function validate_entry_data($data) {
        if (empty($data['title'])) {
            return new WP_Error('invalid_data', 'Title is required', ['status' => 400]);
        }
        return true;
    }
}