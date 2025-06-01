<?php
/**
 * Plugin Name: CustomDataManager
 * Description: A plugin to manage custom data entries via REST API.
 * Version: 1.0.0
 * Author: Sami Afzal
 * License: GNU GPL-V3.0
 */

if (!defined('ABSPATH')) {
    exit;  
}

// Load necessary files
require_once plugin_dir_path(__FILE__) . 'includes/class-post-type.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-rest-api.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-database.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-validation.php';

// Initialize plugin classes
new SamiDataManager_Post_Type();
new SamiDataManager_REST_API();