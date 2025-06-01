# CustomDataManager-WordPress-Plugin-
A WordPress plugin to manage custom data entries via REST API.

Author : Sami Afzal 
Tags: custom data, rest api, crud
Requires at least: 5.6
Tested up to: 6.0
Stable tag: 1.0.0

 
== Installation ==
1. Upload the plugin folder to `/wp-content/plugins/`.
2. Activate the plugin via the WordPress admin.

== REST API Endpoints ==
GET    /wp-json/custom-data-manager/v1/entries          (List all entries)
GET    /wp-json/custom-data-manager/v1/entries/{id}     (Get single entry)
POST   /wp-json/custom-data-manager/v1/entries          (Create entry)
PUT    /wp-json/custom-data-manager/v1/entries/{id}     (Update entry)
DELETE /wp-json/custom-data-manager/v1/entries/{id}     (Delete entry)

#Authentication#
Requires WordPress admin/editor permissions.
