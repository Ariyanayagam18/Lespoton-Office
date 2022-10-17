CREATE TABLE "account_activities" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "account_id" integer, "device_id" integer, "result" varchar(255), "message" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "account_device_relations" ("account_id" integer, "device_id" integer)
;

CREATE TABLE "account_device_tests" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "account_id" integer, "device_id" integer, "test_using_port" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "accounts" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "username" varchar(255), "encrypted_password" varchar(255), "auth_type" varchar(255), "description" varchar(255), "user_description" varchar(255), "discovery" boolean, "system" boolean, "pending" boolean, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "activities" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "action" varchar(255), "info" text, "dismissed" boolean DEFAULT 'f', "created_at" datetime, "updated_at" datetime, "activity_group_id" integer)
;

CREATE TABLE "activity_contexts" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "role" varchar(255), "context_type" varchar(255), "activity_id" integer, "context_id" integer)
;

CREATE TABLE "activity_groups" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "ad_computers" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "dn" varchar(255) NOT NULL, "name" varchar(255), "dnshostname" varchar(255), "iscriticalsystemobject" boolean, "lastlogontimestamp" datetime, "objectsid" varchar(255), "operatingsystem" varchar(255), "operatingsystemservicepack" varchar(255), "operatingsystemversion" varchar(255), "whenchanged" datetime, "whencreated" datetime, "device_id" integer(10), "description" varchar(255))
;

CREATE TABLE "ad_users" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "dn" varchar(255), "badpasswordtime" datetime, "badpwdcount" integer DEFAULT 0, "cn" varchar(255), "co" varchar(255), "company" varchar(255), "department" varchar(255), "description" varchar(255), "displayname" varchar(255), "givenname" varchar(255), "l" varchar(255), "lastlogontimestamp" datetime, "lockouttime" datetime, "mail" varchar(255), "memberof" varchar(255), "objectsid" varchar(255), "physicaldeliveryofficename" varchar(255), "postalcode" varchar(255), "pwdlastset" datetime, "samaccountname" varchar(255), "sn" varchar(255), "st" varchar(255), "streetaddress" varchar(255), "telephonenumber" varchar(255), "useraccountcontrol" varchar(255), "userprincipalname" varchar(255), "whenchanged" datetime, "whencreated" datetime, "user_id" integer(10), "title" varchar(255), "mobile" varchar(255), "manager" varchar(255))
;

CREATE TABLE "agreement_features" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "agreement_id" integer, "name" varchar(255), "value" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "agreements" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "vendor_id" integer, "url" varchar(255), "phone" varchar(255), "account" varchar(255), "email" varchar(255), "service_start" date, "service_end" date, "cost" float, "cost_unit" varchar(255), "account_manager" varchar(255), "description" text, "domain_name" varchar(255), "domain_date_registered" date, "domain_date_expiry" date, "created_at" datetime, "updated_at" datetime, "old_contacts" text, "agreement_type" varchar(255), "software_license_type" varchar(255), "software_version" varchar(255), "software_license_keys" text, "software_license_count" text, "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "type" varchar(255), "account_username" varchar(255), "account_password" varchar(255), "rest_api_key" varchar(255), "rest_secret_key" varchar(255), "reseller" boolean, "service_name" varchar(255), "ping" integer)
;

CREATE TABLE "alerts" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "alerttype_id" integer NOT NULL, "alertable_id" integer(10), "title" varchar(75), "message" text, "active" integer DEFAULT 1 NOT NULL, "data_monitor_id" integer(10), "created_at" datetime, "alertable_type" varchar(255), "type" varchar(255) DEFAULT 'MonitorAlert', "updated_at" datetime, "lookup_key" varchar(255), "lookup_info" varchar(255), "monitorable_id" integer, "monitorable_type" varchar(255), "feature" varchar(255), "resolution_difficulty" integer, "error_class" varchar(255), "error_group" varchar(255), "ticket_id" integer)
;

CREATE TABLE "alerttypes" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "description" varchar(50))
;

CREATE TABLE "alt_profiles" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "user_id" integer, "email" varchar(255))
;

CREATE TABLE "anti_virus_products" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "name" varchar(255), "vendor" varchar(255), "up_to_date" integer, "version" varchar(255))
;

CREATE TABLE "attachments" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "content_type" varchar(255), "size" integer, "filename" varchar(255), "attachable_id" integer, "attachable_type" varchar(255), "created_at" datetime, "updated_at" datetime, "description" text, "user_id" integer, "content_name" text)
;

CREATE TABLE "auth_access_tokens" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "token" varchar(255), "secret" varchar(255), "auth_service_provider_id" integer, "user_id" integer, "created_at" datetime, "updated_at" datetime, "refresh_token" varchar(255), "expires_in" integer, "expires_at" integer)
;

CREATE TABLE "auth_service_providers" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "vendor" varchar(255), "consumer_key" varchar(255), "consumer_secret" varchar(255), "options" text, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "avg_accounts_p_839aeb99_cd33_48ce_ad9f_62b792de1bd7_1372778440" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "account_id" integer DEFAULT 0, "account_name" varchar(255) DEFAULT '', "external_id" integer DEFAULT 0, "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "avg_alert_logs_p_839aeb99_cd33_48ce_ad9f_62b792de1bd7_1372778440" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "alert_log_id" integer DEFAULT 0, "alert_type_id" integer DEFAULT 0, "account_id" integer DEFAULT 0, "event_severity_id" integer DEFAULT 0, "alert_name" varchar(255) DEFAULT '', "event_name" varchar(255) DEFAULT '', "device_id" integer DEFAULT 0, "device_name" varchar(255) DEFAULT '', "alert_details" varchar(255) DEFAULT '', "alert_created_at" datetime, "acknowledged" boolean DEFAULT 'f', "full_details" varchar(255) DEFAULT '', "external_id" integer DEFAULT 0, "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "avg_devices_p_839aeb99_cd33_48ce_ad9f_62b792de1bd7_1372778440" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_id" integer DEFAULT 0, "account_id" integer DEFAULT 0, "device_name" varchar(255) DEFAULT '', "wan_ip" varchar(255) DEFAULT '', "external_id" integer DEFAULT 0, "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "avg_virus_vaults_p_839aeb99_cd33_48ce_ad9f_62b792de1bd7_1372778440" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "virus_vault_id" integer DEFAULT 0, "object_name" varchar(255) DEFAULT '', "orig_object_name" varchar(255) DEFAULT '', "process_id" integer DEFAULT 0, "threat_description" varchar(255) DEFAULT '', "threat_state" varchar(255) DEFAULT '', "detection_time" datetime, "device_id" integer DEFAULT 0, "external_id" integer DEFAULT 0, "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "battery_backup_connections" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_id" integer, "battery_backup_id" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "battery_backup_events" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "description" varchar(255), "time" date, "created_at" datetime, "updated_at" datetime, "code" varchar(255), "battery_backup_id" integer, "name" varchar(255), "alertable" boolean DEFAULT 't', "raw_time" datetime)
;

CREATE TABLE "battery_backup_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "battery_backup_id" integer, "spice_version" integer, "current_output_load" integer DEFAULT NULL, "current_capacity_percent" integer DEFAULT NULL, "battery_replacement_date" date DEFAULT NULL, "updated_at" datetime DEFAULT NULL, "versioned_type" varchar(255) DEFAULT NULL)
;

CREATE TABLE "battery_backups" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "type" varchar(255), "device_id" integer, "manufacturer" varchar(255), "model" varchar(255), "design_capacity_minutes" integer, "design_capacity_mw" integer, "current_output_load" integer, "current_capacity_minutes" integer, "current_capacity_percent" integer, "time_on_battery" integer, "time_to_full_charge" integer, "expected_runtime_minutes" integer, "battery_status" varchar(255), "needs_battery_replacement" boolean, "battery_replacement_date" date, "install_date" date, "created_at" datetime, "updated_at" datetime, "serial_number" varchar(255), "builtin_events" varchar(255), "spice_version" integer)
;

CREATE TABLE "canonical_names" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "licensed" boolean DEFAULT 'f', "unwanted" boolean DEFAULT 'f', "user_modified" boolean DEFAULT 't', "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "canvas_app_cards" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "canvas_app_id" integer, "location" integer, "url" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "canvas_app_services" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "permission_level" integer, "include_sensitive" boolean, "canvas_app_id" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "canvas_app_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "canvas_app_id" integer, "num" varchar(255), "change_notes" text, "min_app_version" varchar(255), "max_app_version" varchar(255), "state" integer, "approved_at" datetime, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "canvas_apps" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "canvas_url" varchar(255), "namespace" varchar(255), "version" varchar(255), "created_at" datetime, "updated_at" datetime, "icon_url" varchar(255), "description" text, "app_center_id" integer, "enabled" boolean, "oauth_uid" varchar(255), "hide_sidebar" boolean DEFAULT 'f', "reserve_timestamp" datetime DEFAULT NULL)
;

CREATE TABLE "categories" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "type" varchar(255), "applies_to" varchar(255), "find_conditions" varchar(255), "condition" varchar(255), "front_page" boolean, "position" integer, "counter_conditions" varchar(255), "icon" varchar(255), "built_in" boolean DEFAULT 'f', "live_update" boolean DEFAULT 'f')
;

CREATE TABLE "cloud_layers" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "type" varchar(255), "layer_id" integer NOT NULL, "location" varchar(255), "condition" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "cloud_service_descriptions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "community_product_id" integer, "url" varchar(255), "disabled" boolean, "created_at" datetime, "updated_at" datetime, "icon_url" varchar(255), "api_url" varchar(255), "watch_list" integer, "user_generated" boolean DEFAULT 'f', "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "ip_detection_count" integer DEFAULT 0, "regex_detection_count" integer DEFAULT 0, "pinned" integer DEFAULT 0)
;

CREATE TABLE "cloud_service_detection_histories" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "cloud_service_description_id" integer, "date" datetime, "detection_count" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "cloud_service_detections" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_id" integer, "cloud_service_description_id" integer, "detected_at" datetime, "created_at" datetime, "updated_at" datetime, "ip_address" varchar(255), "device_port" integer DEFAULT 0, "external_port" integer DEFAULT 0, "exe" varchar(255), "user" varchar(255), "direction" integer, "cloud_service_range_id" integer, "cloud_service_regex_id" integer)
;

CREATE TABLE "cloud_service_encounters" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_id" integer, "cloud_service_description_id" integer, "cloud_service_range_id" integer, "cloud_service_regex_id" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "cloud_service_features" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "cloud_service_id" integer, "name" varchar(255), "value" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "cloud_service_ignored_devices" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "cloud_service_description_id" integer, "device_id" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "cloud_service_product_infos" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "icon_url" varchar(255), "product_name" varchar(255), "vendor_name" varchar(255), "community_id" varchar(255), "product_url" varchar(255), "cloud_service_class_name" varchar(255), "cloud_service_category" varchar(255), "feature_description" varchar(255), "required_login_info" text, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "cloud_service_ranges" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "octet1_min" integer, "octet1_max" integer, "octet2_min" integer, "octet2_max" integer, "octet3_min" integer, "octet3_max" integer, "octet4_min" integer, "octet4_max" integer, "cloud_service_description_id" integer, "upvotes" integer DEFAULT 0, "downvotes" integer DEFAULT 0, "detection_count" integer DEFAULT 0)
;

CREATE TABLE "cloud_service_regexes" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "cloud_service_description_id" integer, "regex" varchar(255), "detection_count" integer DEFAULT 0, "created_at" datetime, "updated_at" datetime, "match_type" integer DEFAULT 1)
;

CREATE TABLE "cloud_service_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "cloud_service_id" integer, "ping_version" integer, "ping" integer DEFAULT NULL, "versioned_type" varchar(255) DEFAULT NULL, "updated_at" datetime)
;

CREATE TABLE "cloud_services" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "vendor_id" integer, "url" varchar(255), "phone" varchar(255), "account" varchar(255), "email" varchar(255), "type" varchar(255), "service_start" date, "service_end" date, "cost" float, "cost_unit" varchar(255), "account_manager" varchar(255), "description" text, "domain_name" varchar(255), "domain_date_registered" date, "domain_date_expiry" date, "old_contacts" text, "software_license_type" varchar(255), "software_version" varchar(255), "software_license_keys" text, "software_license_count" text, "warning_alert_count" integer, "error_alert_count" integer, "open_ticket_count" integer, "account_username" varchar(255), "account_password" varchar(255), "rest_api_key" varchar(255), "rest_secret_key" varchar(255), "reseller" boolean, "service_name" varchar(255), "ping" integer, "ping_version" integer, "created_at" datetime, "updated_at" datetime, "cloud_service_product_info_id" integer, "cert_pem" text, "cert_key" text)
;

CREATE TABLE "collaborations" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "ticket_id" integer, "collaborator_id" integer, "created_at" datetime, "updated_at" datetime, "status" varchar(255) DEFAULT 'pending')
;

CREATE TABLE "collaborators" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "url" varchar(255), "remote_id" varchar(255), "created_at" datetime, "updated_at" datetime, "email" varchar(255), "public_name" varchar(255), "avatar_url" varchar(255))
;

CREATE TABLE "column_configs" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "model" varchar(255), "col_type" varchar(255) DEFAULT 'string', "options" varchar(255), "label" varchar(255), "overridden" boolean, "overriding" boolean, "custom" boolean, "hidden" boolean, "editable" boolean, "generated" boolean, "select_sql" varchar(255), "join_sql" varchar(255), "publicly_visible" boolean DEFAULT 'f', "group_sql" varchar(255), "category" varchar(255), "description" text, "is_nullable" boolean DEFAULT 'f')
;

CREATE TABLE "comments" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "ticket_id" integer NOT NULL, "body" text NOT NULL, "created_at" datetime, "updated_at" datetime, "created_by" integer, "is_public" boolean DEFAULT 't', "attachment_location" varchar(255), "attachment_content_type" varchar(255), "attachment_name" varchar(255), "is_purchase" boolean DEFAULT 'f', "is_labor" boolean, "is_inventory" boolean DEFAULT 'f', "collaborator_id" integer, "remote_id" integer, "comment_type" varchar(255) DEFAULT 'response' NOT NULL, "attachment_size" integer)
;

CREATE TABLE "company" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(20) NOT NULL, "phone" varchar(10) DEFAULT '', "fax" varchar(10) DEFAULT '', "address1" varchar(60) DEFAULT '', "address2" varchar(60) DEFAULT '', "city" varchar(60) DEFAULT '', "state" varchar(60) DEFAULT '', "zipcode" varchar(5) DEFAULT '', "country" varchar(20) DEFAULT '', "industry" varchar(255))
;

CREATE TABLE "config_backups" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255) NOT NULL, "backing_file" varchar(255) NOT NULL, "created_on" datetime, "device_id" integer, "device_uid" varchar(255) NOT NULL, "number_changes" integer DEFAULT 0 NOT NULL, "note" varchar(255))
;

CREATE TABLE "configuration" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(50) NOT NULL, "value" varchar(50), "updated_at" datetime)
;

CREATE TABLE "consumer_tokens" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "user_id" integer, "type" varchar(30), "token" varchar(1024), "secret" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "contacts" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "phone" varchar(255), "email_or_web" varchar(255), "contactable_id" integer, "created_at" datetime, "updated_at" datetime, "contactable_type" varchar(255) DEFAULT 'Agreement')
;

CREATE TABLE "custom_ticket_form_fields" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "type" varchar(255), "options" text, "field_order" integer, "default_value" text, "custom_ticket_form_id" integer)
;

CREATE TABLE "custom_ticket_forms" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255))
;

CREATE TABLE "data_monitors" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "model" varchar(50), "active" integer(10) DEFAULT 1 NOT NULL, "notify_user" boolean DEFAULT 'f', "name" varchar(255), "criteria" varchar(255), "qualifier" varchar(255), "category_id" integer, "creates_tickets" boolean, "closes_ticket" boolean, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "deleted_devices" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" text(50), "manufacturer" varchar(50), "model" varchar(50), "product_info_id" integer, "deleted_on" datetime)
;

CREATE TABLE "desktop_monitors" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "name" varchar(50), "screen_height" integer, "screen_width" integer, "monitor_type" varchar(100), "created_at" datetime, "updated_at" datetime, "serial_number" varchar(255), "model_name" varchar(255), "manufacturer" varchar(255), "manufacturer_date" date)
;

CREATE TABLE "device_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_id" integer, "spice_version" integer, "versioned_type" varchar(50) DEFAULT NULL, "updated_at" datetime, "ip_comparable" integer DEFAULT 0)
;

CREATE TABLE "devices" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(50) NOT NULL, "type" varchar(50), "description" varchar(80), "server_name" varchar(50), "domain" varchar(50), "uuid" varchar(50), "manufacturer" varchar(50), "model" varchar(50), "os_serial_number" varchar(70), "windows_product_id" varchar(50), "serial_number" varchar(75), "ip_address" varchar(15), "mac_address" varchar(50), "operating_system" varchar(64), "version" varchar(50), "windows_user" varchar(50), "primary_owner_name" varchar(50), "memory" integer, "management_oid" varchar(75), "up_time" varchar(50), "last_boot_up_time" datetime(30), "service_pack_major_version" integer(3), "service_pack_minor_version" integer(3), "number_of_licensed_users" integer(3), "number_of_processors" integer(3), "processor_type" varchar(50), "created_on" datetime, "updated_on" datetime, "kernel" varchar(255), "page_count" integer, "install_date" datetime, "device_type" varchar(255), "current_user" varchar(255), "bios_version" varchar(255), "location" varchar(255), "online_at" datetime, "offline_at" datetime, "asset_tag" varchar(255), "manually_added" boolean DEFAULT 'f', "bios_date" date, "c_purchase_price" float, "c_purchase_date" date, "b_name" varchar(50), "b_location" varchar(255), "b_device_type" varchar(255), "b_asset_tag" varchar(255), "b_manufacturer" varchar(50), "b_model" varchar(50), "b_primary_owner_name" varchar(50), "b_serial_number" varchar(75), "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "auto_tag" varchar(255), "dn" varchar(255), "user_tag" varchar(255), "exclude_tag" varchar(255), "last_scan_time" datetime, "spice_version" integer, "vpro_level" integer(4) DEFAULT 0, "last_backup_time" datetime, "user_id" integer, "user_primary" boolean DEFAULT 'f', "swid" varchar(255), "product_categories" varchar(255), "domain_role" integer DEFAULT -1, "b_description" varchar(80), "site_id" integer, "reported_by_id" integer, "ip_comparable" integer DEFAULT 0, "scan_state" varchar(255), "last_qrcode_time" datetime, "mdm_service_id" integer, "product_info_id" integer, "processor_architecture" varchar(255), "os_architecture" varchar(255), "scan_preferences" varchar(255), "raw_model" varchar(255), "raw_manufacturer" varchar(255), "raw_operating_system" varchar(255), "raw_processor_type" varchar(255), "port_scan_results" varchar(255), "vm" boolean DEFAULT 'f', "avatar_id" integer, "raw_serial_number" varchar(255))
;

CREATE TABLE "discovery_scans" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "target" varchar(255), "source" varchar(255), "disabled" boolean DEFAULT 'f', "created_at" datetime, "updated_at" datetime, "started_at" datetime, "finished_at" datetime, "scan_job_id" integer)
;

CREATE TABLE "disk_partitions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer, "name" varchar(255), "physical_disk_name" varchar(255), "partition_type" varchar(255), "size" integer(8), "starting_offset" integer(8), "created_at" datetime, "updated_at" datetime, "free_space" integer)
;

CREATE TABLE "disk_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "disk_id" integer, "spice_version" integer, "computer_id" integer(10), "free_space" varchar(70), "size" varchar(70), "updated_on" datetime, "volume_name" varchar(255))
;

CREATE TABLE "disks" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "name" varchar(50) NOT NULL, "description" varchar(70) NOT NULL, "file_system" varchar(70) NOT NULL, "free_space" varchar(70) NOT NULL, "size" varchar(70) NOT NULL, "updated_on" datetime, "spice_version" integer, "volume_name" varchar(255))
;

CREATE TABLE "dns_maps" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "start" varchar(255), "resolves_to" varchar(255), "reverse" varchar(255), "error" integer, "confirmed" boolean DEFAULT 'f', "reported_by_id" integer)
;

CREATE TABLE "documents" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "key" varchar(255), "value" text, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "dropbox_files_p_a4e990a6_c33a_42a9_ba8d_db8ce7a6ce30_1350513079" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "path" varchar(255) DEFAULT '', "size" varchar(255) DEFAULT '', "thumbnail" varchar(255) DEFAULT '', "is_dir" boolean DEFAULT 'f', "modified" varchar(255) DEFAULT '', "external_id" integer DEFAULT 0, "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "dropbox_users_p_a4e990a6_c33a_42a9_ba8d_db8ce7a6ce30_1350513079" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "user_name" varchar(255) DEFAULT '', "max_usage" integer DEFAULT 0, "shared_usage" integer DEFAULT 0, "personal_usage" integer DEFAULT 0, "external_id" integer DEFAULT 0, "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "events" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "uid" integer(10) NOT NULL, "record" integer(10) NOT NULL, "log" varchar(15) NOT NULL, "event_type" varchar(15) NOT NULL, "event_date" datetime NOT NULL, "source" varchar(25) NOT NULL, "user" varchar(25), "message" varchar(512))
;

CREATE TABLE "exception_stats" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "trace" varchar(255), "exception_count" integer, "details" varchar(255))
;

CREATE TABLE "exclusions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "target" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "external_alert_details" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "alert_id" integer, "source" varchar(150), "icon" varchar(300), "raw_data" text, "remote_instance_id" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "feature_usages" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "feature_id" integer NOT NULL, "user_id" integer NOT NULL, "help_viewed" boolean DEFAULT 'f' NOT NULL, "video_viewed" boolean DEFAULT 'f' NOT NULL, "created_at" datetime, "updated_at" datetime, "usage" varchar(255))
;

CREATE TABLE "featured_plugin_notifications" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "guid" varchar(255), "dismissed_at" datetime, "feature_data" text, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "features" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255) NOT NULL, "description" varchar(255) NOT NULL, "help_url" varchar(255), "video_url" varchar(255), "computation" varchar(255), "triggered_by" varchar(255), "user_specific" boolean DEFAULT 'f' NOT NULL, "updated_at" datetime, "created_at" datetime, "position" integer(10), "compute_when_triggered" boolean DEFAULT 'f', "usage" varchar(255), "spice_meter_feature" boolean DEFAULT 'f')
;

CREATE TABLE "firewall_products" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "name" varchar(255), "vendor" varchar(255), "enabled" integer, "version" varchar(255))
;

CREATE TABLE "frontend_rules" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "conditional" varchar(2000) DEFAULT 'true', "action" varchar(2000) DEFAULT '', "data" varchar(2000), "type" varchar(30), "command" varchar(30), "max_count" integer, "count" integer DEFAULT 0, "last_fired" datetime, "expires" datetime, "created_on" datetime, "updated_on" datetime)
;

CREATE TABLE "google_apps_domain_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "google_apps_domain_id" integer, "spice_version" integer, "agreement_id" integer DEFAULT NULL, "edition" varchar(255) DEFAULT NULL, "num_accounts" integer DEFAULT NULL, "usage_in_bytes" integer DEFAULT NULL, "quota_in_mb" integer DEFAULT NULL, "collected_on" datetime DEFAULT NULL, "updated_at" datetime)
;

CREATE TABLE "google_apps_domains" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "cloud_service_id" integer, "name" varchar(255), "edition" varchar(255), "num_accounts" integer, "usage_in_bytes" integer, "quota_in_mb" integer, "collected_on" datetime, "spice_version" integer(4) DEFAULT 1)
;

CREATE TABLE "google_apps_groups" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "google_apps_domain_id" integer, "name" varchar(255), "description" varchar(255), "owners" text, "members" text, "long_name" varchar(255))
;

CREATE TABLE "google_apps_mailbox_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "google_apps_mailbox_id" integer, "spice_version" integer, "google_apps_user_id" integer DEFAULT NULL, "size" integer DEFAULT NULL, "available_size" integer DEFAULT NULL, "max_size" integer DEFAULT NULL, "account_id" varchar(255) DEFAULT NULL, "status" varchar(255) DEFAULT NULL, "primary_account_id" varchar(255) DEFAULT NULL, "primary_account_name" varchar(255) DEFAULT NULL, "service_tier" varchar(255) DEFAULT NULL, "channel" varchar(255) DEFAULT NULL, "suspension_reason" varchar(255) DEFAULT NULL, "creation_time" datetime DEFAULT NULL, "last_login_time" datetime DEFAULT NULL, "last_web_mail_time" datetime DEFAULT NULL, "last_pop_time" datetime DEFAULT NULL, "collected_on" datetime DEFAULT NULL, "updated_at" datetime)
;

CREATE TABLE "google_apps_mailboxes" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "google_apps_domain_id" integer, "google_apps_user_id" integer, "name" varchar(255), "first_name" varchar(255), "last_name" varchar(255), "size" integer, "available_size" integer, "max_size" integer, "account_id" varchar(255), "status" varchar(255), "primary_account_id" varchar(255), "primary_account_name" varchar(255), "service_tier" varchar(255), "channel" varchar(255), "suspension_reason" varchar(255), "creation_time" datetime, "last_login_time" datetime, "last_web_mail_time" datetime, "last_pop_time" datetime, "collected_on" datetime, "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "spice_version" integer)
;

CREATE TABLE "google_apps_users" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "google_apps_domain_id" integer, "user_id" integer, "username" varchar(255), "first_name" varchar(255), "last_name" varchar(255), "suspended" boolean, "ip_whitelisted" boolean, "is_admin" boolean, "change_password_at_next_login" boolean, "agreed_to_terms" boolean, "max_size" integer, "collected_on" datetime, "groups" text, "nicknames" text)
;

CREATE TABLE "group_scan_category_relations" ("group_scan_id" integer, "category_id" integer)
;

CREATE TABLE "group_scan_topic_relations" ("group_scan_id" integer, "topic_id" integer)
;

CREATE TABLE "group_scans" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "disabled" boolean DEFAULT 'f', "created_at" datetime, "updated_at" datetime, "started_at" datetime, "finished_at" datetime)
;

CREATE TABLE "hotfix_descriptions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255) NOT NULL, "description" varchar(255))
;

CREATE TABLE "hotfix_installation_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "hotfix_installation_id" integer, "spice_version" integer, "computer_id" integer, "hotfix_id" integer, "installed_on" datetime, "installed_by" varchar(255))
;

CREATE TABLE "hotfix_installations" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer, "hotfix_id" integer, "installed_on" datetime, "installed_by" varchar(255), "service_pack_in_effect" varchar(255), "created_at" datetime, "updated_at" datetime, "spice_version" integer)
;

CREATE TABLE "hotfixes" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "hotfix_installations_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "ilo_devices" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer, "ilo_oa_id" integer, "device_id" integer, "ilo_firmware" varchar(255), "ilo_server_sn" varchar(255), "ilo_server_name" varchar(255), "ilo_management_processor" varchar(255), "ilo_license" integer DEFAULT 0, "ilo_license_type" varchar(255), "ilo_fan_status" varchar(255), "ilo_fan_redundancy_status" varchar(255), "ilo_power_supply_status" varchar(255), "ilo_power_supply_redundancy_status" varchar(255), "ilo_temperature_status" varchar(255), "ilo_drive_status" varchar(255), "ilo_last_power_reading_value" integer, "ilo_last_power_reading_units" varchar(255), "ilo_avg_power_reading_value" integer, "ilo_avg_power_reading_units" varchar(255), "ilo_max_power_reading_value" integer, "ilo_max_power_reading_units" varchar(255), "ilo_min_power_reading_value" integer, "ilo_min_power_reading_units" varchar(255), "created_at" datetime, "updated_at" datetime, "ilo_firmware_date" varchar(255))
;

CREATE TABLE "interface_routes" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "interface_id" integer, "destination" varchar(255), "mask" varchar(255), "next_hop" varchar(255), "route_type" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "interface_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "interface_id" integer NOT NULL, "device_id" integer(10) NOT NULL, "bps_in" integer, "bps_out" integer, "spice_version" integer, "updated_on" datetime)
;

CREATE TABLE "interfaces" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_id" integer(10) NOT NULL, "name" varchar(50), "ip_address" varchar(16), "mac_address" varchar(20), "mask" varchar(16), "if_type" varchar(16), "admin_status" varchar(15), "op_status" varchar(15), "bps_in" integer, "bps_out" integer, "updated_on" datetime, "spice_version" integer DEFAULT 1, "if_index" varchar(20) DEFAULT NULL, "network" varchar(20) DEFAULT NULL, "speed" integer(12))
;

CREATE TABLE "inventory_ticket_relations" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "ticket_id" integer, "inventory_item_id" integer, "inventory_item_type" varchar(255))
;

CREATE TABLE "joined_ranges" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "na" varchar(6))
;

CREATE TABLE "knowledge_base_articles" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "title" text, "start_content" text, "end_content" text, "ranking" integer, "shared_with" integer, "portal_visible" boolean DEFAULT 'f', "edited_at" datetime, "steps" text, "references" text, "extra_attrs" text, "pro_user_id" integer, "last_modified_by_id" integer, "parent_id" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "knowledge_base_attachments" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "size" integer, "width" integer, "height" integer, "content_type" varchar(255), "filename" varchar(255), "created_at" datetime, "updated_at" datetime, "display_filename" text, "parent_id" integer, "extra_attrs" text, "knowledge_base_article_id" integer, "thumbnail" varchar(255), "user_id" integer)
;

CREATE TABLE "knowledge_base_comments" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "text" text, "pro_user_id" integer, "knowledge_base_article_id" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "license_software_relations" ("software_id" integer, "software_license_id" integer)
;

CREATE TABLE "mail_servers" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "type" varchar(255), "address" varchar(255) NOT NULL, "port" integer, "domain" varchar(255), "user_name" varchar(255), "password" varchar(255), "use_ssl" boolean, "authentication" varchar(255), "sender_email_address" varchar(255), "sender_display_name" varchar(255), "enabled" boolean DEFAULT 't', "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "map_edges" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "target_id" integer NOT NULL, "source_id" integer NOT NULL, "label" varchar(255), "interface_id" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "map_hints" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "from_ip" varchar(20) NOT NULL, "to_ip" varchar(20) NOT NULL, "remark" varchar(255), "created_at" datetime, "updated_at" datetime, "added" boolean DEFAULT 't')
;

CREATE TABLE "map_nodes" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "node_id" integer NOT NULL, "device_id" integer, "name" varchar(60), "ip" varchar(20), "node_type" varchar(50), "cloud" varchar(20), "backbone" boolean DEFAULT 'f', "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "mdm_enrollment_requests" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "mdm_service_id" integer, "status" integer, "requested_at" datetime, "requested_by" varchar(255), "domain" varchar(255), "username" varchar(255), "email_address" varchar(255), "platform" varchar(255), "policySet" varchar(255), "registered_device_name" varchar(255), "registered_at" datetime, "created_at" datetime, "updated_at" datetime, "user_id" integer, "url" varchar(255), "passcode" varchar(255), "qrcode_url" varchar(255), "remote_id" integer, "hide" boolean DEFAULT 'f')
;

CREATE TABLE "mdm_services" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "enrolled_at" datetime, "company_name" varchar(255), "api_username" varchar(255), "api_password" varchar(255), "billing_id" varchar(255), "admin_username" varchar(255), "admin_email" varchar(255), "partner_name" varchar(255), "platform_id" varchar(255), "app_id" varchar(255), "app_version" varchar(255), "app_access_key" varchar(255), "last_scan_at" datetime, "created_at" datetime, "updated_at" datetime, "first_enrollment_status" varchar(255), "first_enrollment_user_id" integer, "remote_id" integer, "apple_csr" text, "apple_certificate" text, "apple_cert_expires_at" datetime, "private_key" text, "account_status" varchar(255), "trial_expires_on" date)
;

CREATE TABLE "memory_slots" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "name" varchar(255) NOT NULL, "status" varchar(255), "memory_type" varchar(255), "speed" varchar(255), "size" integer, "max_capacity" integer)
;

CREATE TABLE "microsoft_exchange_counter_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "microsoft_exchange_counter_id" integer NOT NULL, "computer_id" integer(10) NOT NULL, "rpc_requests" integer, "send_queue_size" integer, "sent_permin" integer, "receive_queue_size" integer, "receive_permin" integer, "spice_version" integer, "updated_on" datetime)
;

CREATE TABLE "microsoft_exchange_counters" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "rpc_requests" integer, "send_queue_size" integer, "sent_permin" integer, "receive_queue_size" integer, "receive_permin" integer, "spice_version" integer DEFAULT 1, "updated_on" datetime)
;

CREATE TABLE "microsoft_exchange_mailboxes" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "display_name" varchar(100), "last_logon" varchar(100), "size" integer, "total_items" integer, "storage" varchar(200))
;

CREATE TABLE "microsoft_exchanges" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "name" varchar(50), "version" varchar(100), "fqdn" varchar(100), "storage" varchar(100), "is_front_end_server" integer, "last_modification_time" datetime, "updated_on" datetime)
;

CREATE TABLE "microsoft_sql_servers" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "name" varchar(255))
;

CREATE TABLE "mobile_device_attributes" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_id" integer, "device_type" varchar(255), "device_status" varchar(255), "maas360_managed_status" varchar(255), "custom_asset_number" varchar(255), "imei_esn" varchar(255), "installed_date" datetime, "last_reported" datetime, "maas360_device_id" varchar(255), "ownership" varchar(255), "username" varchar(255), "email_address" varchar(255), "compliance_state" varchar(255), "out_of_compliance_reasons" varchar(255), "rule_set_configured" varchar(255), "total_free_storage_gb" varchar(255), "device_serial_number" varchar(255), "phone_number" varchar(255), "sim" varchar(255), "processor_name" varchar(255), "ram_mb" varchar(255), "firmware_version" varchar(255), "kernel_version" varchar(255), "modem_firmware_version" varchar(255), "last_sim_change_date" datetime, "data_roaming" varchar(255), "international_data_roaming_enabled" varchar(255), "home_carrier" varchar(255), "current_carrier" varchar(255), "mdm_policy" varchar(255), "policy_compliance_state" varchar(255), "device_rooted" varchar(255), "background_data_sync_enabled" varchar(255), "device_passcode_status" varchar(255), "last_reported_roaming_status" varchar(255), "baseband_version" varchar(255), "total_internal_storage_gb" varchar(255), "free_internal_storage_gb" varchar(255), "total_external_storage_gb" varchar(255), "free_external_storage_gb" varchar(255), "application_data_mb" varchar(255), "rules_compliance_status" varchar(255), "last_mdm_policy_update_date" datetime, "last_mdm_policy_update_source" varchar(255), "last_selective_wipe_applied_date" datetime, "selective_wipe" varchar(255), "last_wipe_applied_date" datetime, "device_wiped" varchar(255), "hardware_encryption" varchar(255), "failed_settings" varchar(255), "settings_failed_to_configure" varchar(255), "settings_configured" varchar(255), "app_compliance_state" varchar(255), "gps_present" varchar(255), "camera_present" varchar(255), "apple_serial_number" varchar(255), "iccid" varchar(255), "device_jailbroken" varchar(255), "application_data_gb" varchar(255), "activation_date" datetime, "allow_explicit_music_and_podcasts" varchar(255), "allow_user_of_i_tunes_music_store" varchar(255), "allow_use_of_you_tube" varchar(255), "allow_user_of_safari" varchar(255), "allow_screen_capture" varchar(255), "allow_use_of_camera" varchar(255), "allow_installing_of_applications" varchar(255), "jailbreak_detection_date" datetime, "selective_wipe_issuer" varchar(255), "platform" varchar(255), "bluetooth_enabled" varchar(255))
;

CREATE TABLE "mobile_software" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "appid" varchar(255), "name" varchar(255), "product_info_id" integer, "platform" varchar(255))
;

CREATE TABLE "mobile_software_installations" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "mobile_software_id" integer, "mobile_device_id" integer, "version" varchar(255), "file_size" integer, "data_size" integer, "external" boolean, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "network_adapter_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "network_adapter_id" integer, "spice_version" integer, "updated_on" datetime DEFAULT NULL, "bps_in" integer, "bps_out" integer, "ip_comparable" integer DEFAULT 0)
;

CREATE TABLE "network_adapters" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(50), "description" varchar(50), "ip_address" varchar(16), "gateway" varchar(16), "net_mask" varchar(16), "mac_address" varchar(20), "dns_domain" varchar(50), "dns_servers" varchar(64), "dhcp_enabled" varchar(10), "dhcp_server" varchar(30), "computer_id" integer(10) NOT NULL, "updated_on" datetime, "net_connection_id" varchar(255), "spice_version" integer, "ip_addresses" varchar(255), "bps_in" integer, "bps_out" integer, "raw_bytes_in" integer, "raw_bytes_out" integer, "ip_comparable" integer DEFAULT 0)
;

CREATE TABLE "network_maps" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "map_name" varchar(255) NOT NULL, "custom_root_node" varchar(255) NOT NULL, "custom_transform_object" varchar(255) NOT NULL, "custom_node_data" varchar(255) NOT NULL, "custom_edge_data" varchar(255) NOT NULL, "original_root_node" varchar(255) NOT NULL, "original_transform_object" varchar(255) NOT NULL, "original_node_data" varchar(255) NOT NULL, "original_edge_data" varchar(255) NOT NULL, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "network_users" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(50), "computer_id" integer(10) NOT NULL, "number_of_logons" integer(10), "full_name" varchar(50), "user_type" varchar(50), "last_logon" datetime, "uid" varchar(255), "home_directory" varchar(255))
;

CREATE TABLE "notes" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "user_id" integer(10), "created_at" datetime, "body" text, "noteable_id" integer, "noteable_type" varchar(255), "updated_at" datetime)
;

CREATE TABLE "office365_distribution_groups" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "office365_organizational_unit_id" integer, "name" varchar(255), "display_name" varchar(255), "group_type" varchar(255), "primary_smtp_address" varchar(255), "members" text, "when_created" datetime, "when_changed" datetime, "collected_on" datetime)
;

CREATE TABLE "office365_mailbox_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "office365_mailbox_id" integer, "spice_version" integer, "active_sync_enabled" boolean DEFAULT NULL, "owa_enabled" boolean DEFAULT NULL, "pop_enabled" boolean DEFAULT NULL, "imap_enabled" boolean DEFAULT NULL, "mapi_enabled" boolean DEFAULT NULL, "has_active_sync_device_partnership" boolean DEFAULT NULL, "is_quarantined" boolean DEFAULT NULL, "junk_mail_config_enabled" boolean DEFAULT NULL, "item_count" integer DEFAULT 0, "size" integer DEFAULT 0, "max_size" integer DEFAULT 0, "collected_on" datetime DEFAULT NULL, "updated_at" datetime, "available_size" integer DEFAULT 0)
;

CREATE TABLE "office365_mailboxes" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "office365_organizational_unit_id" integer, "user_id" integer, "name" varchar(255), "display_name" varchar(255), "primary_smtp_address" varchar(255), "active_sync_enabled" boolean, "owa_enabled" boolean, "pop_enabled" boolean, "imap_enabled" boolean, "mapi_enabled" boolean, "has_active_sync_device_partnership" boolean, "is_quarantined" boolean, "junk_mail_config_enabled" boolean, "item_count" integer DEFAULT 0, "size" integer DEFAULT 0, "max_size" integer DEFAULT 0, "last_logon" datetime, "last_logoff" datetime, "when_created" datetime, "when_changed" datetime, "collected_on" datetime, "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "spice_version" integer, "available_size" integer DEFAULT 0)
;

CREATE TABLE "office365_organizational_units" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "cloud_service_id" integer, "name" varchar(255), "creation_time" datetime, "collected_on" datetime)
;

CREATE TABLE "open_shares" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(50), "resource_type" varchar(50), "user_name" varchar(50), "remote_path" varchar(50), "status" varchar(50), "computer_id" integer(10) NOT NULL, "updated_on" datetime)
;

CREATE TABLE "peripheral_authoritative_usbids" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_name" varchar(255), "manufacturer" varchar(255), "product_identifier" varchar(255), "vendor_identifier" varchar(255))
;

CREATE TABLE "peripheral_instances" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "peripheral_id" integer, "computer_id" integer, "location" varchar(255), "version" varchar(255), "max_power" varchar(255), "used_power" varchar(255), "speed" varchar(255), "windows_device_id" varchar(255), "serial" varchar(255), "source" varchar(255), "status" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "peripherals" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "manufacturer" varchar(255), "product_identifier" varchar(255), "vendor_identifier" varchar(255), "service" varchar(255), "peripheral_instances_count" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "physical_disks" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "number" integer(10), "name" varchar(50), "model" varchar(70) NOT NULL, "size" varchar(70), "free_space" varchar(70), "status" varchar(20), "serial" varchar(70), "interface" varchar(20), "manufacturer" varchar(50), "firmware" varchar(50), "created_at" datetime, "updated_at" datetime, "failure_prediction" varchar(20), "is_solid_state" boolean DEFAULT 'f', "bus_info" varchar(255))
;

CREATE TABLE "plugin_migrations" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "guid" varchar(255), "class_name" varchar(255))
;

CREATE TABLE "plugin_model_instance_relationships" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "model_one_id" integer, "model_one_type" varchar(255), "model_two_id" integer, "model_two_type" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "plugin_service_configuration_values" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "plugin_service_id" integer, "key" varchar(255), "value" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "plugin_service_event_subscriptions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "publisher_id" integer, "subscription_alias" varchar(255), "subscriber_id" integer, "event_symbol" varchar(255), "method_name" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "plugin_services" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "type" varchar(255), "plugin_id" integer, "data" text, "loaded" boolean, "service_hash" text, "parent_service_id" integer, "created_at" datetime, "updated_at" datetime, "plugin_guid" varchar(255), "namespace_key" varchar(255))
;

CREATE TABLE "plugin_trend_points" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_id" integer, "key" varchar(255) NOT NULL, "value" varchar(255) NOT NULL, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "plugins" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "description" text, "version" varchar(255), "enabled" boolean, "created_at" datetime, "updated_at" datetime, "guid" varchar(255), "installed" boolean, "shared" boolean, "update_available" boolean, "killed" boolean, "user_id" integer, "save_count" integer DEFAULT 0, "shared_at_count" integer DEFAULT 0, "purchased" boolean DEFAULT 'f', "tags" varchar(255), "is_server_mod" boolean, "execution_context" varchar(255), "built_in" boolean, "minimum_app_version" varchar(255), "maximum_app_version" varchar(255), "platform_managed" boolean DEFAULT 'f', "platform_content_type" varchar(255))
;

CREATE TABLE "port_mappings" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_id" integer NOT NULL, "interface_id" integer, "vlan" varchar(255), "name" varchar(255), "network_device_id" integer)
;

CREATE TABLE "printer_supplies" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "network_printer_id" integer(10) NOT NULL, "name" varchar(255) NOT NULL, "color" varchar(255), "max_level" integer NOT NULL, "current_level" integer NOT NULL, "level" integer NOT NULL, "type_id" integer NOT NULL, "spice_version" integer, "average_cartridge_life" integer, "projected_empty_date" datetime, "updated_at" datetime, "created_at" datetime)
;

CREATE TABLE "printer_supply_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "printer_supply_id" integer, "spice_version" integer, "current_level" integer DEFAULT NULL, "level" integer DEFAULT NULL, "updated_at" datetime)
;

CREATE TABLE "printers" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(50), "computer_id" integer(10) NOT NULL, "default" varchar(50), "print_processor" varchar(50), "printer_device" varchar(50), "horizontal_resolution" varchar(50), "vertical_resolution" varchar(50), "updated_on" datetime)
;

CREATE TABLE "product_info" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "type" varchar(255), "image_url" varchar(255), "model_name" varchar(255), "vendor_name" varchar(255), "community_product_id" integer, "category" varchar(255), "description" text, "collected_at" datetime, "avg_rating" float, "rating_count" integer)
;

CREATE TABLE "purchase_list_items" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(200) NOT NULL, "user_id" integer NOT NULL, "purchased" boolean DEFAULT 'f', "ticket_id" integer, "created_at" datetime, "received" boolean DEFAULT 'f', "received_at" datetime, "purchased_at" datetime, "price" float DEFAULT 0.0, "approved" boolean DEFAULT 'f', "approved_at" datetime, "charge_to" varchar(255) DEFAULT '', "agreement_id" integer, "part_number" varchar(255), "purchase_order" varchar(255), "notes" text, "quantity" integer DEFAULT 1, "shipping_code" varchar(255), "updated_at" datetime, "purchased_for_id" integer, "purchased_for_type" varchar(255), "category" varchar(255) DEFAULT 'Miscellaneous', "subcategory" varchar(255) DEFAULT 'Uncategorized', "order_number" varchar(255), "quote_id" integer DEFAULT 0, "upc" varchar(255) DEFAULT '', "gid" varchar(255) DEFAULT '', "research_class" varchar(255) DEFAULT '', "research_code" varchar(255) DEFAULT '', "product_image" varchar(255) DEFAULT '', "purchase_link" varchar(255) DEFAULT '', "vendor_id" integer)
;

CREATE TABLE "purchase_list_items_comments" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "purchase_list_item_id" integer, "comment_id" integer)
;

CREATE TABLE "push_receivers" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "service_identifier" int, "events" varchar(1024), "user_id" integer)
;

CREATE TABLE "queued_remote_requests" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "remote_collector_id" integer, "request_params" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "rackspace_customers" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "cloud_service_id" integer, "account_number" varchar(255), "name" varchar(255), "ref_number" varchar(255))
;

CREATE TABLE "rackspace_distribution_lists" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "rackspace_domain_id" integer, "name" varchar(255), "description" varchar(255), "email_addresses" text, "alias" boolean DEFAULT 'f')
;

CREATE TABLE "rackspace_distribution_lists_rackspace_mailboxes" ("rackspace_distribution_list_id" integer NOT NULL, "rackspace_mailbox_id" integer NOT NULL)
;

CREATE TABLE "rackspace_domain_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "rackspace_domain_id" integer, "spice_version" integer, "rsemail_mailboxes" integer(4) DEFAULT NULL, "rsemail_max_mailboxes" integer(4) DEFAULT NULL, "rsemail_mailbox_base_size" integer(4) DEFAULT NULL, "rsemail_mailbox_extra_storage_size" integer(4) DEFAULT NULL, "rsemail_total_storage" integer DEFAULT NULL, "exchange_mailboxes" integer(4) DEFAULT NULL, "exchange_max_mailboxes" integer(4) DEFAULT NULL, "exchange_mailbox_base_size" integer(4) DEFAULT NULL, "exchange_mailbox_extra_storage_size" integer(4) DEFAULT NULL, "exchange_total_storage" integer DEFAULT NULL, "archiving_service_enabled" boolean DEFAULT NULL, "blackberry_mobile_service_enabled" boolean DEFAULT NULL, "blackberry_used_licenses" integer(4) DEFAULT NULL, "blackberry_licenses" integer(4) DEFAULT NULL, "activesync_mobile_service_enabled" boolean DEFAULT NULL, "activesync_used_licenses" integer(4) DEFAULT NULL, "activesync_licenses" integer(4) DEFAULT NULL, "collected_on" datetime DEFAULT NULL, "updated_at" datetime)
;

CREATE TABLE "rackspace_domains" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "rackspace_customer_id" integer, "name" varchar(255), "service_type" varchar(255), "rsemail_mailboxes" integer(4), "rsemail_max_mailboxes" integer(4), "rsemail_mailbox_base_size" integer(4), "rsemail_mailbox_extra_storage_size" integer(4), "rsemail_total_storage" integer, "exchange_mailboxes" integer(4), "exchange_max_mailboxes" integer(4), "exchange_mailbox_base_size" integer(4), "exchange_mailbox_extra_storage_size" integer(4), "exchange_total_storage" integer, "archiving_service_enabled" boolean, "blackberry_mobile_service_enabled" boolean, "blackberry_used_licenses" integer(4), "blackberry_licenses" integer(4), "activesync_mobile_service_enabled" boolean, "activesync_used_licenses" integer(4), "activesync_licenses" integer(4), "collected_on" datetime, "spice_version" integer(4) DEFAULT 1)
;

CREATE TABLE "rackspace_mailbox_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "rackspace_mailbox_id" integer, "spice_version" integer, "size" integer DEFAULT NULL, "available_size" integer DEFAULT NULL, "max_size" integer DEFAULT NULL, "has_activesync" boolean DEFAULT 'f', "has_blackberry" boolean DEFAULT 'f', "collected_on" datetime DEFAULT NULL, "updated_at" datetime)
;

CREATE TABLE "rackspace_mailboxes" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "rackspace_domain_id" integer, "name" varchar(255), "mbox_type" varchar(255), "size" integer, "available_size" integer, "max_size" integer, "has_activesync" boolean DEFAULT 'f', "has_blackberry" boolean DEFAULT 'f', "collected_on" datetime, "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "spice_version" integer, "display_name" varchar(255), "first_name" varchar(255), "last_name" varchar(255), "enabled" boolean DEFAULT 't', "last_login" datetime, "additional_email_addresses" text, "company" varchar(255), "department" varchar(255), "title" varchar(255), "address" varchar(255), "city" varchar(255), "state" varchar(255), "zip" varchar(255), "country" varchar(255), "business_number" varchar(255), "mobile_number" varchar(255), "pager_number" varchar(255), "fax_number" varchar(255), "home_number" varchar(255), "notes" text, "user_id" integer, "created_on" datetime)
;

CREATE TABLE "range_entries" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "range" varchar(255), "disabled" boolean, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "recommendation_data_sources" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255) NOT NULL, "type" varchar(255), "value" decimal, "code" text, "created_at" datetime, "updated_at" datetime, "md5" varchar(255))
;

CREATE TABLE "recommendation_instances" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "recommendation_id" integer, "vector_id" integer, "user_id" integer NOT NULL, "data" text, "type" varchar(255), "created_at" datetime, "updated_at" datetime, "md5" varchar(255), "weights_vector_id" integer, "dismissed" datetime)
;

CREATE TABLE "recommendation_log" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "recommendation_instance_id" integer, "action" varchar(255), "upload_state" integer DEFAULT 0 NOT NULL, "type" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "recommendation_score_sets" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "user_id" integer, "created_at" datetime, "updated_at" datetime, "upload_state" integer DEFAULT 0, "type" varchar(255))
;

CREATE TABLE "recommendation_scores" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "score_set_id" integer, "recommendation_instance_id" integer, "score" float)
;

CREATE TABLE "recommendation_term_names" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "term_name" varchar(255))
;

CREATE TABLE "recommendation_terms" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "term_name_id" integer NOT NULL, "value" float, "vector_id" integer NOT NULL, "updated_at" datetime)
;

CREATE TABLE "recommendation_vectors" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "created_at" datetime, "updated_at" datetime, "default_value" float DEFAULT 0.0)
;

CREATE TABLE "recommendations" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "vector_id" integer NOT NULL, "name" varchar(255) NOT NULL, "type" varchar(255), "deployed_from_backend" boolean DEFAULT 'f' NOT NULL, "created_at" datetime, "updated_at" datetime, "data_sources" text, "code" text, "weights_vector_id" integer, "md5" varchar(255), "expected_dynamic_terms" integer DEFAULT 1)
;

CREATE TABLE "remote_agent_metrics" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "remote_collectors_id" integer, "handshake_attempts" integer DEFAULT 0, "full_scan_count" integer DEFAULT 0, "diff_scan_count" integer DEFAULT 0, "failed_scan_count" integer DEFAULT 0, "upgrade_count" integer DEFAULT 0)
;

CREATE TABLE "remote_collectors" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "host" varchar(255), "name" varchar(255), "uuid" varchar(255), "version" varchar(255), "created_at" datetime, "updated_at" datetime, "url" varchar(255), "last_contact" datetime, "enabled" boolean, "private_key" varchar(2048), "public_key" varchar(2048), "authorized" boolean, "type" varchar(40), "reachable" boolean, "pending_deletion" boolean DEFAULT 'f', "scan_queued" boolean DEFAULT 'f', "settings_updated" boolean DEFAULT 'f', "site_id" integer)
;

CREATE TABLE "remote_control_sessions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "type" varchar(255), "ticket_id" integer, "user_id" integer, "remote_session_id" varchar(255), "code" varchar(255), "status" varchar(255), "scheduled_start" datetime, "actual_start" datetime, "duration" float, "auth_service_provider_id" integer, "created_at" datetime, "updated_at" datetime, "session_end" datetime)
;

CREATE TABLE "report_fields" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "report_id" integer NOT NULL, "field_name" varchar(80) NOT NULL, "created_on" datetime, "updated_on" datetime, "field_order" integer DEFAULT 0)
;

CREATE TABLE "report_instances" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "file" varchar(255), "report_schedule_id" integer, "created_at" datetime, "updated_at" datetime, "date" datetime)
;

CREATE TABLE "report_schedules" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "schedule" varchar(255), "email" boolean, "email_addresses" text, "format" varchar(255), "stored" integer, "report_id" integer, "created_at" datetime, "updated_at" datetime, "enabled" boolean DEFAULT 'f', "first_at" datetime, "require_results_to_send" boolean DEFAULT 't')
;

CREATE TABLE "reports" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "user_id" integer, "name" varchar(40) NOT NULL, "and_or" varchar(3) DEFAULT 'and' NOT NULL, "created_on" datetime, "updated_on" datetime, "description" varchar(200), "last_run" datetime, "type" varchar(255), "public" boolean DEFAULT 't', "is_widgetable" boolean DEFAULT 'f', "widget_type" varchar(255), "sql" varchar(1024), "graph_types_id" integer, "widget_sizes_id" integer, "b_name" varchar(40), "b_description" varchar(200), "b_sql" varchar(1024), "uid" varchar(255), "edit_mode" varchar(255), "special_report_type" integer DEFAULT 0)
;

CREATE TABLE "resource_uses" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "resource_id" integer, "resource_type" varchar(255), "count" integer DEFAULT 0, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "rule_sets" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "and_or" varchar(255), "klass" varchar(255), "live_update" boolean DEFAULT 'f', "created_at" datetime, "updated_at" datetime, "parent_id" integer, "parent_type" varchar(255))
;

CREATE TABLE "rules" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "type" varchar(255), "rule_set_id" integer, "attribute" varchar(255), "value" varchar(255), "position" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "running_processes" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "pid" integer NOT NULL, "name" varchar(255), "command_line" varchar(255), "memory" integer, "cpu_percent" integer, "updated_on" datetime, "user" varchar(32))
;

CREATE TABLE "scalextreme_alerts" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "triggerid" integer, "alertid" integer, "description" varchar(255), "description_text" varchar(255), "error" varchar(255), "expression" varchar(255), "flags" integer, "hosts" varchar(255), "lastchange" varchar(255), "priority" integer, "status" integer, "templateid" integer, "alert_type" integer, "url" varchar(255), "alert_value" varchar(255), "value_flags" varchar(255), "comments" varchar(255), "session_id" varchar(255))
;

CREATE TABLE "scan_job_group_scan_relations" ("scan_job_id" integer, "group_scan_id" integer)
;

CREATE TABLE "scan_jobs" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "state" varchar(255), "progress" integer DEFAULT 0, "created_at" datetime, "updated_at" datetime, "finder_pid" varchar(255), "scan_type" varchar(255), "source" varchar(255), "completed_at" datetime, "started_at" datetime, "remote_collector_id" integer)
;

CREATE TABLE "scan_schedules" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "days" varchar(255), "starting_hour" integer DEFAULT 0, "rescan_interval" integer DEFAULT 240, "schedulable_id" integer, "schedulable_type" varchar(255))
;

CREATE TABLE "scan_stats" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "scan_job_id" integer, "version" varchar(255), "created_at" datetime, "desktop" integer, "laptop" integer, "server" integer, "fax" integer, "firewall" integer, "copier" integer, "router" integer, "network_printer" integer, "unknown" integer, "switch" integer, "hub" integer, "http_device" integer, "voip_device" integer, "wireless" integer, "snmp_device" integer, "nas" integer, "ilo" integer, "ilo_oa" integer, "tablet" integer, "smartphone" integer, "enable_authentication" integer, "esx_authentication" integer, "esx_unknown" integer, "ilo_authentication" integer, "one_by_one" integer, "ssh_authentication" integer, "ssh_fingerprint" integer, "ssh_firewall" integer, "telnet_authentication" integer, "windows_authentication" integer, "windows_firewall" integer, "unexpected_error_group" integer, "other_device_type" integer)
;

CREATE TABLE "scan_tasks" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "scan_job_id" integer, "device_id" integer, "processed" boolean DEFAULT 'f', "progress" integer, "created_at" datetime, "updated_at" datetime, "device_type" varchar(255), "topics" text)
;

CREATE TABLE "scan_topics" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255))
;

CREATE TABLE "schema_info" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "version" integer)
;

CREATE TABLE "schema_migrations" ("version" varchar(255) NOT NULL)
;

CREATE TABLE "server_features" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "feature" integer, "parent" integer, "name" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "service_installation_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "service_installation_id" integer, "spice_version" integer, "computer_id" integer, "service_id" integer, "status" varchar(255), "state" varchar(255), "start_mode" varchar(255), "updated_at" datetime)
;

CREATE TABLE "service_installations" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer, "service_id" integer, "status" varchar(255) DEFAULT 'OK', "state" varchar(255), "start_mode" varchar(255), "created_at" datetime, "updated_at" datetime, "spice_version" integer)
;

CREATE TABLE "services" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "description" varchar(255), "service_installations_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "created_at" datetime, "updated_at" datetime, "accept_stop" boolean, "accept_pause" boolean)
;

CREATE TABLE "share_permissions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "share_id" integer, "account" varchar(255), "list_permission" boolean DEFAULT 'f', "add_file_permission" boolean DEFAULT 'f', "add_subdir_permission" boolean DEFAULT 'f', "read_ea_permission" boolean DEFAULT 'f', "write_ea_permission" boolean DEFAULT 'f', "traverse_permission" boolean DEFAULT 'f', "delete_child_permission" boolean DEFAULT 'f', "read_attr_permission" boolean DEFAULT 'f', "write_attr_permission" boolean DEFAULT 'f', "delete_permission" boolean DEFAULT 'f', "read_control_permission" boolean DEFAULT 'f', "write_dac_permission" boolean DEFAULT 'f', "write_owner_permission" boolean DEFAULT 'f', "synchronize_permission" boolean DEFAULT 'f', "ad_user_id" integer, "permission_type" varchar(255))
;

CREATE TABLE "shares" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(50), "path" varchar(50), "status" varchar(50), "computer_id" integer(10) NOT NULL, "updated_on" datetime, "disk_id" integer, "last_modified" datetime, "caption" varchar(255), "owner" varchar(255), "group" varchar(255), "share_type" integer, "created_at" datetime)
;

CREATE TABLE "site_memberships" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "user_id" integer, "site_id" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "sites" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "description" varchar(255), "created_at" datetime, "updated_at" datetime, "is_default" boolean DEFAULT 'f')
;

CREATE TABLE "snmp_neighbors" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_id" integer NOT NULL, "if_index" varchar(20), "neighbor_if_name" varchar(255), "neighbor" varchar(255))
;

CREATE TABLE "software" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "vendor" varchar(50), "install_date" date, "url_info_about" varchar(150), "url_update_info" varchar(150), "licenses" integer, "software_installations_count" integer DEFAULT 0, "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "open_ticket_count" integer DEFAULT 0, "created_at" datetime, "updated_at" datetime, "display_name" varchar(255), "swgroup" varchar(255), "summary" varchar(255))
;

CREATE TABLE "software_installation_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "software_installation_id" integer, "spice_version" integer, "software_id" integer, "computer_id" integer(10), "version" varchar(50), "install_date" date, "updated_at" datetime, "uninstall_string" varchar(255), "from_wmi" boolean DEFAULT 'f', "from_linux" boolean DEFAULT 'f')
;

CREATE TABLE "software_installations" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "software_id" integer, "computer_id" integer, "software_license_id" integer, "product_id" varchar(150), "identity" varchar(150), "version" varchar(50) DEFAULT 'unknown', "install_date" date, "created_at" datetime, "updated_at" datetime, "license_verified" boolean DEFAULT 'f', "spice_version" integer, "license_verified_by" varchar(255), "license_verified_on" datetime, "uninstall_string" varchar(255), "from_wmi" boolean DEFAULT 'f', "network_user_id" integer, "install_location" varchar(255), "from_linux" boolean DEFAULT 'f')
;

CREATE TABLE "software_licenses" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "type" varchar(255), "key" varchar(255), "seat_limit" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "software_name_maps" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "software_id" integer, "canonical_name_id" integer, "title_hash" blob, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "software_packages" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "guid" varchar(255), "file_name" varchar(255), "install_path" varchar(255), "created_at" datetime, "updated_at" datetime, "version" varchar(255), "url" varchar(255))
;

CREATE TABLE "spiceworks_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "version" varchar(255) NOT NULL, "created_at" datetime)
;

CREATE TABLE "taggings" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "tag_id" integer, "taggable_id" integer, "taggable_type" varchar(255))
;

CREATE TABLE "tags" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255))
;

CREATE TABLE "ticket_dashboard_widgets" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "title" varchar(255), "description" varchar(255), "order" integer NOT NULL, "display_as" varchar(255), "data_source" varchar(255), "group_by" varchar(255), "date_by" varchar(255), "ticket_dashboard_id" integer, "report_id" integer)
;

CREATE TABLE "ticket_dashboards" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "title" varchar(255), "description" varchar(255))
;

CREATE TABLE "ticket_involvements" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "user_id" integer, "ticket_id" integer, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "ticket_view_overrides" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "user_id" integer, "view_name" varchar(255), "hidden_cols" varchar(255), "sort_by" varchar(255), "sort_dir" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "ticket_work" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "ticket_id" integer, "user_id" integer, "time_spent" integer, "labor" decimal DEFAULT 0 NOT NULL, "created_at" datetime, "updated_at" datetime, "rate" decimal)
;

CREATE TABLE "tickets" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "summary" varchar(50) NOT NULL, "status" varchar(255) NOT NULL, "description" text, "priority" integer, "created_at" datetime, "updated_at" datetime, "closed_at" datetime, "created_by" integer, "assigned_to" integer, "viewed_at" datetime, "reopened" boolean, "requires_purchase" boolean, "category" varchar(255), "external_id" varchar(255), "email_message_id" varchar(255), "status_updated_at" datetime, "warning_alert_count" integer DEFAULT 0, "error_alert_count" integer DEFAULT 0, "muted" boolean, "site_id" integer, "master_ticket_id" integer, "reported_by_id" integer, "due_at" datetime, "remote_id" integer, "synced_at" datetime, "sharer_id" integer, "parent_id" integer, "billing_rate" decimal, "first_response_secs" integer, "c_first_sub_cat" varchar(255), "c_second_sub_cat" varchar(255), "c_third_sub_cat" varchar(255), "c_fourth_sub_cat" varchar(255), "c_contact_name" varchar(255), "c_customer_name" varchar(255), "c_owner" varchar(255))
;

CREATE TABLE "unitrends" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "status" varchar(255), "level" varchar(255), "notification" varchar(255), "message" varchar(255), "object" varchar(255), "received" datetime)
;

CREATE TABLE "unprobed_devices" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_type" varchar(255), "name" varchar(255), "mac_address" varchar(255), "ip_address" varchar(255), "finder_uid" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "url_caches" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "url" varchar(255), "cache" text, "icon" text, "expires_at" datetime, "expires_every" integer, "updated_at" datetime)
;

CREATE TABLE "user_invitations" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "first_name" varchar(255), "last_name" varchar(255), "email" varchar(255), "note" text, "resource_id" integer, "resource_type" varchar(255), "url" varchar(255) NOT NULL, "redeemed" datetime, "expires" datetime, "authentication_token" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "user_portal_blocks" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "location" varchar(255), "text" varchar(255), "options" text, "created_at" datetime, "updated_at" datetime, "last_updated_by_id" integer)
;

CREATE TABLE "user_portal_built_ins" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "symbol" varchar(255), "options" text, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "user_portal_layouts" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "key" varchar(255), "value" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "user_portal_pages" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "sort" integer, "main_content" text, "sidebar_content" text, "preferences" text, "internal_reference_name" varchar(255), "created_at" datetime, "updated_at" datetime, "last_updated_by_id" integer)
;

CREATE TABLE "users" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "encrypted_password" varchar(20) NOT NULL, "first_name" varchar(64), "last_name" varchar(64), "email" varchar(80) NOT NULL, "company_id" integer(10), "logon_count" integer(10) DEFAULT 0, "display_name" varchar(255), "registered" datetime, "role" varchar(255), "auth_token" varchar(255), "verified" boolean, "display_name_set" boolean, "home_page" varchar(255), "third_party" boolean, "options" text, "survey_offers" boolean DEFAULT 'f', "visible" boolean DEFAULT 't', "community_unread_message_count" integer, "community_activity_count" integer, "community_activity_seen_at" datetime, "office_phone" varchar(255), "cell_phone" varchar(255), "title" varchar(255), "location" varchar(255) DEFAULT 'Main Office', "start_date" date, "department" varchar(255) DEFAULT 'Marketing', "supervisor_id" integer, "disabled" datetime, "created_at" datetime, "updated_at" datetime, "preference_vector_id" integer, "notification_preferences" integer DEFAULT 0, "community_preferences_cache_vector_id" integer, "billing_rate" decimal DEFAULT 50.0 NOT NULL, "type" varchar(255), "password_salt" varchar(255), "community_email" varchar(255), "reset_password_token" varchar(255), "remember_token" varchar(255), "remember_created_at" datetime, "community_uid" varchar(255))
;

CREATE TABLE "vendors" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "description" text, "website" varchar(255), "phone" varchar(255), "street_line_1" varchar(255), "street_line_2" varchar(255), "city" varchar(255), "state" varchar(255), "country" varchar(255), "zipcode" varchar(255), "created_at" datetime, "updated_at" datetime, "account_number" varchar(255), "primary_contact_name" varchar(255), "primary_contact_email" varchar(255))
;

CREATE TABLE "video_controllers" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "name" varchar(50), "device_name" varchar(100), "drivers" varchar(100), "driver_version" varchar(100), "driver_date" datetime, "video_processor" varchar(255), "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "virtual_machines" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "vm_host_id" integer NOT NULL, "asset_device_id" integer, "name" varchar(255) NOT NULL, "uuid" varchar(255) NOT NULL, "vcpu_count" integer, "memory" integer, "hdd_capacity" integer, "mac_addresses" varchar(255), "on_off" varchar(255), "guest_os_hint" varchar(255), "config_file_path" varchar(255), "config_last_modified" datetime, "tools_version" varchar(255), "created_at" datetime, "updated_at" datetime, "on_time" datetime, "off_time" datetime, "guest_ip_addr" varchar(255), "bios_uuid" varchar(255))
;

CREATE TABLE "vlan_ports" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_id" integer(10) NOT NULL, "name" varchar(50), "vlan" varchar(50), "ip_address" varchar(16), "mac_address" varchar(20), "status" varchar(15), "updated_on" datetime)
;

CREATE TABLE "vm_hosts" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "computer_id" integer(10) NOT NULL, "name" varchar(255) NOT NULL, "version" varchar(255), "patch" varchar(255), "license_key" varchar(255), "license_kind" varchar(255), "eval_expires" datetime, "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "warranties" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "vendor_id" integer, "description" varchar(255) DEFAULT '', "start_date" date, "end_date" date, "price" float, "provider_name" varchar(255), "warranty_collection_id" integer, "deliverables" varchar(255), "service_level" varchar(255), "is_muted" boolean DEFAULT 'f', "is_custom" boolean DEFAULT 'f', "created_at" datetime, "updated_at" datetime)
;

CREATE TABLE "warranty_collections" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_id" integer NOT NULL, "last_scan_date" date, "next_scan_date" date, "ship_date" date, "device_product_number" varchar(255), "b_device_product_number" varchar(255), "is_stat_trapped" boolean, "required_params_hash" varchar(255))
;

CREATE TABLE "web_domain_versions" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "web_domain_id" integer, "ping_version" integer, "agreement_id" integer DEFAULT NULL, "updated_at" datetime DEFAULT NULL, "ping" integer DEFAULT NULL, "ping_hostname" varchar(255) DEFAULT NULL, "http_status" varchar(255))
;

CREATE TABLE "web_domains" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "cloud_service_id" integer, "name" varchar(255), "registrar" varchar(255), "dns_provider" varchar(255), "expiration_date" datetime, "created_at" datetime, "updated_at" datetime, "ping_version" integer, "ping" integer, "http_status" varchar(255), "ssl_expiry" datetime, "should_http" boolean DEFAULT 't', "should_ping" boolean DEFAULT 'f')
;

CREATE TABLE "webroot_entries" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "device_id" integer, "sku" varchar(255), "software_version" varchar(255), "language" varchar(255), "hostname" varchar(255), "id_shield" boolean, "web_threat_shield" boolean, "zero_day_shield" boolean, "realtime_shield" boolean, "usb_shield" boolean, "behavior_shield" boolean, "core_system" boolean, "offline_shield" boolean, "active_threats" text, "removed_threats" text, "expiration_date" integer, "last_check_in" integer, "last_scan_duration" integer, "scan_frequency" integer, "scheduled_scans_enabled" boolean, "last_scan_count" integer, "total_scans" integer, "scheduled_scan_time" varchar(255), "created_at" datetime, "updated_at" datetime, "name" varchar(255), "extra_data" text)
;

CREATE TABLE "webservers" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "title" varchar(50), "device_id" integer(10), "server_name" varchar(100), "name" varchar(50), "port" integer(10) DEFAULT 80, "updated_on" datetime)
;

CREATE TABLE "widgets" ("id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "name" varchar(255), "title" varchar(255), "description" text, "default_settings" text, "icon" varchar(255), "type" varchar(255), "category" varchar(255), "short_title" varchar(255))
;

INSERT INTO accounts(id, username, encrypted_password, auth_type, description, user_description, discovery, system, pending, created_at, updated_at) VALUES (1, null, 'J1i+BAhfKF0vyrpOgUsuew==', 'snmp', 'public community string', 'public community string', 't', 't', null, '2016-03-09 23:04:02', '2016-03-09 23:04:02');

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (14, 'user_created', '--- 
:source: :user
:user_email: spiceworks_builtin_account_do_not_alter
:user_id: 1
', 'f', '2016-03-09 23:08:36', '2016-03-09 23:08:36', 14);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (15, 'ticket_comment_added', '--- 
:body: Creator changed to System Admin.
:comment_id: 
:comment_name: "Ticket #1"
:ticket_id: 1
:ticket_summary: Welcome to the Spiceworks Help Desk
', 'f', '2016-03-09 23:08:36', '2016-03-09 23:08:36', 15);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (16, 'user_created', '--- 
:source: :user
:user_email: themachinehdtest@kelsan.biz
:user_id: 2
', 'f', '2016-03-09 23:08:36', '2016-03-09 23:08:36', 16);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (17, 'cloud_service_created', '--- 
:account: 
:cloud_service_id: 1
:cloud_service_name: NETWORK SOLUTIONS INC.
:cloud_service_type: DomainService
:service_end: 
:website: 
', 'f', '2016-03-09 23:08:47', '2016-03-09 23:08:47', 17);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (18, 'web_domain_created', '--- 
:account: 
:cloud_service_id: 1
:cloud_service_name: NETWORK SOLUTIONS INC.
:cloud_service_type: DomainService
:service_end: 
:web_domain: 
  cloud_service_id: 1
  created_at: 2016-03-09 23:08:47.506789 -05:00
  dns_provider: Dynect
  expiration_date: 2025-03-20T23:59:59+00:00
  http_status: "200"
  id: 1
  name: kelsan.biz
  ping: 1
  ping_version: 2
  registrar: NETWORK SOLUTIONS INC.
  should_http: true
  should_ping: true
  ssl_expiry: 
  updated_at: 2016-03-09 23:08:54.358474 -05:00
:website: 
', 'f', '2016-03-09 23:08:54', '2016-03-09 23:08:54', 18);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (19, 'cloud_service_created', '--- 
:account: 
:cloud_service_id: 2
:cloud_service_name: Claris Networks LLC
:cloud_service_type: ISPService
:service_end: 
:website: 
', 'f', '2016-03-09 23:08:54', '2016-03-09 23:08:54', 19);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (20, 'ticket_comment_added', '--- 
:body: Assigned to TheMachine HDTest.
:by: TheMachine H.
:by_id: 2
:comment_id: 1
:comment_name: "Ticket #1"
:ticket_id: 1
:ticket_summary: Welcome to the Spiceworks Help Desk
', 'f', '2016-03-09 23:32:24', '2016-03-09 23:32:24', 20);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (21, 'ticket_reassigned', '--- 
:assigned_to: TheMachine H.
:by: TheMachine H.
:by_id: 2
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: System Account
:summary: Welcome to the Spiceworks Help Desk
:ticket_id: 1
:to: TheMachine H.
:to_id: 2
', 'f', '2016-03-09 23:32:24', '2016-03-09 23:32:24', 21);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (22, 'ticket_comment_added', '--- 
:body: Assigned to TheMachine HDTest.
:by: TheMachine H.
:by_id: 2
:comment_id: 1
:comment_name: "Ticket #1"
:ticket_id: 1
:ticket_summary: Welcome to the Spiceworks Help Desk
', 'f', '2016-03-09 23:32:24', '2016-03-09 23:32:24', 22);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (23, 'ticket_updated', '--- 
:assigned_to: TheMachine H.
:by: TheMachine H.
:by_id: 2
:changes: 
  status_updated_at: 
  - "2016-03-07"
  - "2016-03-09"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: System Account
:summary: Welcome to the Spiceworks Help Desk
:ticket_id: 1
', 'f', '2016-03-09 23:32:24', '2016-03-09 23:32:24', 23);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (24, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: TheMachine H.
:by_id: 2
:comment_id: 2
:comment_name: "Ticket #1"
:ticket_id: 1
:ticket_summary: Welcome to the Spiceworks Help Desk
', 'f', '2016-03-09 23:32:26', '2016-03-09 23:32:26', 24);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (25, 'ticket_closed', '--- 
:assigned_to: TheMachine H.
:by: TheMachine H.
:by_id: 2
:device_ids: []

:due_at: 
:email: themachinehdtest@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: System Account
:summary: Welcome to the Spiceworks Help Desk
:ticket_id: 1
', 'f', '2016-03-09 23:32:26', '2016-03-09 23:32:26', 25);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (26, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: TheMachine H.
:by_id: 2
:comment_id: 2
:comment_name: "Ticket #1"
:ticket_id: 1
:ticket_summary: Welcome to the Spiceworks Help Desk
', 'f', '2016-03-09 23:32:26', '2016-03-09 23:32:26', 26);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (27, 'ticket_updated', '--- 
:assigned_to: TheMachine H.
:by: TheMachine H.
:by_id: 2
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-09"
  - "2016-03-09"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: System Account
:summary: Welcome to the Spiceworks Help Desk
:ticket_id: 1
', 'f', '2016-03-09 23:32:26', '2016-03-09 23:32:26', 27);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (28, 'user_created', '--- 
:source: :user
:user_email: lthompson@kelsan.biz
:user_id: 3
', 'f', '2016-03-09 23:35:46', '2016-03-09 23:35:46', 28);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (29, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: lthompson
:by_id: 3
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: CustServ HD Test Email
:ticket_id: 2
', 'f', '2016-03-09 23:35:46', '2016-03-09 23:35:46', 29);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (30, 'user_updated', '--- 
:by: TheMachine H.
:by_id: 2
:source: :user
:updated: 
  first_name: Lee
  last_name: Thompson
  role: admin
:user_email: lthompson@kelsan.biz
:user_id: 3
', 'f', '2016-03-10 00:10:12', '2016-03-10 00:10:12', 30);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (31, 'user_updated', '--- 
:by: Lee T.
:by_id: 3
:source: :user
:updated: 
  role: end_user
:user_email: themachinehdtest@kelsan.biz
:user_id: 2
', 'f', '2016-03-10 00:17:39', '2016-03-10 00:17:39', 30);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (32, 'ticket_comment_added', '--- 
:body: Assigned to Lee Thompson.
:by: Lee T.
:by_id: 3
:comment_id: 3
:comment_name: "Ticket #2"
:ticket_id: 2
:ticket_summary: CustServ HD Test Email
', 'f', '2016-03-10 00:19:06', '2016-03-10 00:19:06', 31);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (33, 'ticket_reassigned', '--- 
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: CustServ HD Test Email
:ticket_id: 2
:to: Lee T.
:to_id: 3
', 'f', '2016-03-10 00:19:06', '2016-03-10 00:19:06', 32);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (34, 'ticket_comment_added', '--- 
:body: Assigned to Lee Thompson.
:by: Lee T.
:by_id: 3
:comment_id: 3
:comment_name: "Ticket #2"
:ticket_id: 2
:ticket_summary: CustServ HD Test Email
', 'f', '2016-03-10 00:19:06', '2016-03-10 00:19:06', 33);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (35, 'ticket_updated', '--- 
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:changes: 
  status_updated_at: 
  - 
  - "2016-03-10"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: CustServ HD Test Email
:ticket_id: 2
', 'f', '2016-03-10 00:19:06', '2016-03-10 00:19:06', 34);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (36, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Lee T.
:by_id: 3
:comment_id: 4
:comment_name: "Ticket #2"
:ticket_id: 2
:ticket_summary: CustServ HD Test Email
', 'f', '2016-03-10 00:19:11', '2016-03-10 00:19:11', 35);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (37, 'ticket_closed', '--- 
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:device_ids: []

:due_at: 
:email: lthompson@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: CustServ HD Test Email
:ticket_id: 2
', 'f', '2016-03-10 00:19:11', '2016-03-10 00:19:11', 36);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (38, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Lee T.
:by_id: 3
:comment_id: 4
:comment_name: "Ticket #2"
:ticket_id: 2
:ticket_summary: CustServ HD Test Email
', 'f', '2016-03-10 00:19:11', '2016-03-10 00:19:11', 37);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (39, 'ticket_updated', '--- 
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-10"
  - "2016-03-10"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: CustServ HD Test Email
:ticket_id: 2
', 'f', '2016-03-10 00:19:12', '2016-03-10 00:19:12', 38);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (40, 'user_created', '--- 
:by: Lee T.
:by_id: 3
:source: :user
:user_email: swhitson@kelsan.biz
:user_id: 4
', 'f', '2016-03-10 10:19:10', '2016-03-10 10:19:10', 39);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (41, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Lee T.
:by_id: 3
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Test ticket
:ticket_id: 3
', 'f', '2016-03-10 10:22:43', '2016-03-10 10:22:43', 40);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (42, 'ticket_comment_added', '--- 
:body: Assigned to Lee Thompson.
:by: Lee T.
:by_id: 3
:comment_id: 5
:comment_name: "Ticket #3"
:ticket_id: 3
:ticket_summary: Test ticket
', 'f', '2016-03-10 10:26:06', '2016-03-10 10:26:06', 41);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (43, 'ticket_reassigned', '--- 
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Test ticket
:ticket_id: 3
:to: Lee T.
:to_id: 3
', 'f', '2016-03-10 10:26:06', '2016-03-10 10:26:06', 42);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (44, 'ticket_comment_added', '--- 
:body: Assigned to Lee Thompson.
:by: Lee T.
:by_id: 3
:comment_id: 5
:comment_name: "Ticket #3"
:ticket_id: 3
:ticket_summary: Test ticket
', 'f', '2016-03-10 10:26:06', '2016-03-10 10:26:06', 43);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (45, 'ticket_updated', '--- 
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:changes: 
  status_updated_at: 
  - 
  - "2016-03-10"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Test ticket
:ticket_id: 3
', 'f', '2016-03-10 10:26:06', '2016-03-10 10:26:06', 44);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (46, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Lee T.
:by_id: 3
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Email Loop Filtering Test
:ticket_id: 4
', 'f', '2016-03-10 12:55:03', '2016-03-10 12:55:03', 45);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (47, 'ticket_comment_added', '--- 
:body: Assigned to Lee Thompson.
:by: Lee T.
:by_id: 3
:comment_id: 6
:comment_name: "Ticket #4"
:ticket_id: 4
:ticket_summary: Email Loop Filtering Test
', 'f', '2016-03-10 12:56:55', '2016-03-10 12:56:55', 46);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (48, 'ticket_reassigned', '--- 
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Email Loop Filtering Test
:ticket_id: 4
:to: Lee T.
:to_id: 3
', 'f', '2016-03-10 12:56:55', '2016-03-10 12:56:55', 47);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (49, 'ticket_comment_added', '--- 
:body: Assigned to Lee Thompson.
:by: Lee T.
:by_id: 3
:comment_id: 6
:comment_name: "Ticket #4"
:ticket_id: 4
:ticket_summary: Email Loop Filtering Test
', 'f', '2016-03-10 12:56:55', '2016-03-10 12:56:55', 48);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (50, 'ticket_updated', '--- 
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:changes: 
  status_updated_at: 
  - 
  - "2016-03-10"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Email Loop Filtering Test
:ticket_id: 4
', 'f', '2016-03-10 12:56:55', '2016-03-10 12:56:55', 49);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (51, 'ticket_comment_added', '--- 
:body: Comment loop testing.
:by: Lee T.
:by_id: 3
:comment_id: 7
:comment_name: "Ticket #4"
:ticket_id: 4
:ticket_summary: Email Loop Filtering Test
', 'f', '2016-03-10 12:57:26', '2016-03-10 12:57:26', 50);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (52, 'ticket_comment_added', '--- 
:body: Comment loop testing.
:by: Lee T.
:by_id: 3
:comment_id: 7
:comment_name: "Ticket #4"
:ticket_id: 4
:ticket_summary: Email Loop Filtering Test
', 'f', '2016-03-10 12:57:26', '2016-03-10 12:57:26', 50);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (53, 'ticket_comment_added', '--- 
:body: Lee Thompson worked for 15m, making 15m total time spent on this ticket -
:by: Lee T.
:by_id: 3
:comment_id: 8
:comment_name: "Ticket #4"
:ticket_id: 4
:ticket_summary: Email Loop Filtering Test
', 'f', '2016-03-10 12:58:59', '2016-03-10 12:58:59', 50);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (54, 'ticket_comment_added', '--- 
:body: Lee Thompson worked for 15m, making 15m total time spent on this ticket -
:by: Lee T.
:by_id: 3
:comment_id: 8
:comment_name: "Ticket #4"
:ticket_id: 4
:ticket_summary: Email Loop Filtering Test
', 'f', '2016-03-10 12:58:59', '2016-03-10 12:58:59', 50);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (55, 'ticket_updated_time', '--- 
:added: 900
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:device_ids: []

:due_at: 
:making: 900
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Email Loop Filtering Test
:ticket_id: 4
', 'f', '2016-03-10 12:58:59', '2016-03-10 12:58:59', 51);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (56, 'ticket_updated', '--- 
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:changes: 
  category: 
  - New Order
  - Research
  status_updated_at: 
  - "2016-03-10"
  - "2016-03-10"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Email Loop Filtering Test
:ticket_id: 4
', 'f', '2016-03-10 12:59:47', '2016-03-10 12:59:47', 52);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (57, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Lee T.
:by_id: 3
:comment_id: 9
:comment_name: "Ticket #4"
:ticket_id: 4
:ticket_summary: Email Loop Filtering Test
', 'f', '2016-03-10 13:00:17', '2016-03-10 13:00:17', 53);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (58, 'ticket_closed', '--- 
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:device_ids: []

:due_at: 
:email: lthompson@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Email Loop Filtering Test
:ticket_id: 4
', 'f', '2016-03-10 13:00:17', '2016-03-10 13:00:17', 54);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (59, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Lee T.
:by_id: 3
:comment_id: 9
:comment_name: "Ticket #4"
:ticket_id: 4
:ticket_summary: Email Loop Filtering Test
', 'f', '2016-03-10 13:00:17', '2016-03-10 13:00:17', 55);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (60, 'ticket_updated', '--- 
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-10"
  - "2016-03-10"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Email Loop Filtering Test
:ticket_id: 4
', 'f', '2016-03-10 13:00:17', '2016-03-10 13:00:17', 56);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (61, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Lee T.
:by_id: 3
:comment_id: 10
:comment_name: "Ticket #3"
:ticket_id: 3
:ticket_summary: Test ticket
', 'f', '2016-03-10 13:00:23', '2016-03-10 13:00:23', 57);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (62, 'ticket_closed', '--- 
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:device_ids: []

:due_at: 
:email: lthompson@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Test ticket
:ticket_id: 3
', 'f', '2016-03-10 13:00:23', '2016-03-10 13:00:23', 58);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (63, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Lee T.
:by_id: 3
:comment_id: 10
:comment_name: "Ticket #3"
:ticket_id: 3
:ticket_summary: Test ticket
', 'f', '2016-03-10 13:00:23', '2016-03-10 13:00:23', 59);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (64, 'ticket_updated', '--- 
:assigned_to: Lee T.
:by: Lee T.
:by_id: 3
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-10"
  - "2016-03-10"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Test ticket
:ticket_id: 3
', 'f', '2016-03-10 13:00:23', '2016-03-10 13:00:23', 60);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (65, 'user_created', '--- 
:by: Scott W.
:by_id: 4
:source: :user
:user_email: mkilburn@kelsan.biz
:user_id: 5
', 'f', '2016-03-14 12:26:56', '2016-03-14 12:26:56', 61);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (66, 'user_created', '--- 
:by: Scott W.
:by_id: 4
:source: :user
:user_email: ryan.heintz@ballistix.com
:user_id: 6
', 'f', '2016-03-14 16:43:28', '2016-03-14 16:43:28', 61);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (67, 'user_created', '--- 
:by: Scott W.
:by_id: 4
:source: :user
:user_email: hemalatha.gopisetty@ballistix.com
:user_id: 7
', 'f', '2016-03-16 08:15:15', '2016-03-16 08:15:15', 61);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (71, 'ticket_comment_added', '--- 
:body: Assigned to Hemalatha Gopisetty.
:by: Hemalatha G.
:by_id: 7
:comment_id: 11
:comment_name: "Ticket #5"
:ticket_id: 5
:ticket_summary: Test Ticket 1
', 'f', '2016-03-17 23:46:00', '2016-03-17 23:46:00', 65);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (72, 'ticket_reassigned', '--- 
:assigned_to: Hemalatha G.
:by: Hemalatha G.
:by_id: 7
:device_ids: []

:due_at: 2016-03-24 17:00:00 -04:00
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: hemalatha.gopisetty@ballistix.com
:summary: Test Ticket 1
:ticket_id: 5
:to: Hemalatha G.
:to_id: 7
', 'f', '2016-03-17 23:46:00', '2016-03-17 23:46:00', 66);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (73, 'ticket_comment_added', '--- 
:body: Assigned to Hemalatha Gopisetty.
:by: Hemalatha G.
:by_id: 7
:comment_id: 11
:comment_name: "Ticket #5"
:ticket_id: 5
:ticket_summary: Test Ticket 1
', 'f', '2016-03-17 23:46:00', '2016-03-17 23:46:00', 67);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (75, 'ticket_comment_added', '--- 
:body: Assigned to Hemalatha Gopisetty.
:by: Hemalatha G.
:by_id: 7
:comment_id: 11
:comment_name: "Ticket #5"
:ticket_id: 5
:ticket_summary: Test Ticket 1
', 'f', '2016-03-17 23:46:00', '2016-03-17 23:46:00', 69);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (76, 'ticket_opened', '--- 
:assigned_to: Hemalatha G.
:by: Hemalatha G.
:by_id: 7
:device_ids: 
- 26
:due_at: 2016-03-24 17:00:00 -04:00
:past_due: false
:priority: Med
:related_to: Evernote
:submitter_display_name: hemalatha.gopisetty@ballistix.com
:summary: Test Ticket 1
:ticket_id: 5
', 'f', '2016-03-17 23:46:00', '2016-03-17 23:46:00', 70);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (80, 'ticket_comment_added', '--- 
:body: This is a test note
:by: Hemalatha G.
:by_id: 7
:comment_id: 12
:comment_name: "Ticket #5"
:ticket_id: 5
:ticket_summary: Test Ticket 1
', 'f', '2016-03-17 23:46:50', '2016-03-17 23:46:50', 74);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (82, 'ticket_comment_added', '--- 
:body: This is a test note
:by: Hemalatha G.
:by_id: 7
:comment_id: 12
:comment_name: "Ticket #5"
:ticket_id: 5
:ticket_summary: Test Ticket 1
', 'f', '2016-03-17 23:46:50', '2016-03-17 23:46:50', 76);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (84, 'ticket_updated', '--- 
:assigned_to: Hemalatha G.
:by: Hemalatha G.
:by_id: 7
:changes: 
  status_updated_at: 
  - 
  - "2016-03-17"
:device_ids: 
- 26
:due_at: 2016-03-24 17:00:00 -04:00
:past_due: false
:priority: Med
:related_to: Evernote
:submitter_display_name: hemalatha.gopisetty@ballistix.com
:summary: Test Ticket 1
:ticket_id: 5
', 'f', '2016-03-17 23:47:11', '2016-03-17 23:47:11', 78);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (87, 'ticket_comment_added', '--- 
:body: Assigned to Scott Whitson.
:by: Scott W.
:by_id: 4
:comment_id: 13
:comment_name: "Ticket #6"
:ticket_id: 6
:ticket_summary: Testing
', 'f', '2016-03-21 14:20:16', '2016-03-21 14:20:16', 81);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (88, 'ticket_reassigned', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Testing
:ticket_id: 6
:to: Scott W.
:to_id: 4
', 'f', '2016-03-21 14:20:16', '2016-03-21 14:20:16', 82);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (89, 'ticket_comment_added', '--- 
:body: Assigned to Scott Whitson.
:by: Scott W.
:by_id: 4
:comment_id: 13
:comment_name: "Ticket #6"
:ticket_id: 6
:ticket_summary: Testing
', 'f', '2016-03-21 14:20:16', '2016-03-21 14:20:16', 83);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (90, 'ticket_opened', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Testing
:ticket_id: 6
', 'f', '2016-03-21 14:20:16', '2016-03-21 14:20:16', 84);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (91, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  status_updated_at: 
  - 
  - "2016-03-21"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Testing
:ticket_id: 6
', 'f', '2016-03-21 14:20:50', '2016-03-21 14:20:50', 85);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (92, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Scott W.
:by_id: 4
:comment_id: 14
:comment_name: "Ticket #7"
:ticket_id: 7
:ticket_summary: Adding Additional Users
', 'f', '2016-03-21 14:24:03', '2016-03-21 14:24:03', 86);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (93, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Scott W.
:by_id: 4
:comment_id: 14
:comment_name: "Ticket #7"
:ticket_id: 7
:ticket_summary: Adding Additional Users
', 'f', '2016-03-21 14:24:03', '2016-03-21 14:24:03', 86);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (94, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Scott W.
:by_id: 4
:comment_id: 14
:comment_name: "Ticket #7"
:ticket_id: 7
:ticket_summary: Adding Additional Users
', 'f', '2016-03-21 14:24:03', '2016-03-21 14:24:03', 86);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (95, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Adding Additional Users
:ticket_id: 7
', 'f', '2016-03-21 14:24:04', '2016-03-21 14:24:04', 87);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (96, 'ticket_comment_added', '--- 
:body: Assigned to Scott Whitson.
:by: Scott W.
:by_id: 4
:comment_id: 15
:comment_name: "Ticket #7"
:ticket_id: 7
:ticket_summary: Adding Additional Users
', 'f', '2016-03-21 14:26:11', '2016-03-21 14:26:11', 88);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (97, 'ticket_reassigned', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Adding Additional Users
:ticket_id: 7
:to: Scott W.
:to_id: 4
', 'f', '2016-03-21 14:26:11', '2016-03-21 14:26:11', 89);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (98, 'ticket_comment_added', '--- 
:body: Assigned to Scott Whitson.
:by: Scott W.
:by_id: 4
:comment_id: 15
:comment_name: "Ticket #7"
:ticket_id: 7
:ticket_summary: Adding Additional Users
', 'f', '2016-03-21 14:26:11', '2016-03-21 14:26:11', 90);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (99, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  status_updated_at: 
  - 
  - "2016-03-21"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Adding Additional Users
:ticket_id: 7
', 'f', '2016-03-21 14:26:11', '2016-03-21 14:26:11', 91);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (100, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  category: 
  - About Kelsan
  - Account Setup
  status_updated_at: 
  - "2016-03-21"
  - "2016-03-21"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Adding Additional Users
:ticket_id: 7
', 'f', '2016-03-21 14:28:04', '2016-03-21 14:28:04', 91);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (101, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Scott W.
:by_id: 4
:comment_id: 16
:comment_name: "Ticket #6"
:ticket_id: 6
:ticket_summary: Testing
', 'f', '2016-03-21 14:30:26', '2016-03-21 14:30:26', 92);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (102, 'ticket_closed', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:email: swhitson@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Testing
:ticket_id: 6
', 'f', '2016-03-21 14:30:26', '2016-03-21 14:30:26', 93);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (103, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Scott W.
:by_id: 4
:comment_id: 16
:comment_name: "Ticket #6"
:ticket_id: 6
:ticket_summary: Testing
', 'f', '2016-03-21 14:30:26', '2016-03-21 14:30:26', 94);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (104, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-21"
  - "2016-03-21"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Testing
:ticket_id: 6
', 'f', '2016-03-21 14:30:26', '2016-03-21 14:30:26', 95);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (105, 'user_created', '--- 
:by: Scott W.
:by_id: 4
:source: :user
:user_email: sstapleton@kelsan.biz
:user_id: 8
', 'f', '2016-03-22 10:34:40', '2016-03-22 10:34:40', 96);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (106, 'user_created', '--- 
:by: Scott W.
:by_id: 4
:source: :user
:user_email: eheaton@kelsan.biz
:user_id: 9
', 'f', '2016-03-22 10:34:58', '2016-03-22 10:34:58', 96);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (107, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Scott W.
:by_id: 4
:comment_id: 17
:comment_name: "Ticket #7"
:ticket_id: 7
:ticket_summary: Adding Additional Users
', 'f', '2016-03-22 10:35:09', '2016-03-22 10:35:09', 97);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (108, 'ticket_closed', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:email: swhitson@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Adding Additional Users
:ticket_id: 7
', 'f', '2016-03-22 10:35:09', '2016-03-22 10:35:09', 98);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (109, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Scott W.
:by_id: 4
:comment_id: 17
:comment_name: "Ticket #7"
:ticket_id: 7
:ticket_summary: Adding Additional Users
', 'f', '2016-03-22 10:35:09', '2016-03-22 10:35:09', 99);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (110, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-21"
  - "2016-03-22"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Adding Additional Users
:ticket_id: 7
', 'f', '2016-03-22 10:35:09', '2016-03-22 10:35:09', 100);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (112, 'user_created', '--- 
:by: Scott W.
:by_id: 4
:source: :user
:user_email: bshipley@kelsan.biz
:user_id: 10
', 'f', '2016-03-22 10:36:59', '2016-03-22 10:36:59', 102);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (113, 'plugin_installed', '--- 
:by: Scott W.
:by_id: 4
:plugin_guid: p-669fbd20-c76b-012d-9c42-002481f9d9ec-1295057388
:plugin_id: 15
:plugin_name: Subcategories
', 'f', '2016-03-22 10:38:49', '2016-03-22 10:38:49', 103);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (114, 'plugin_installed', '--- 
:by: Scott W.
:by_id: 4
:plugin_guid: p-c7289bb3-04d0-41c9-ac19-106e2bff14d8-1419341372
:plugin_id: 16
:plugin_name: Subcategories XML for 7.3+
', 'f', '2016-03-22 13:08:03', '2016-03-22 13:08:03', 104);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (115, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  status_updated_at: 
  - "2016-03-22"
  - "2016-03-22"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Adding Additional Users
:ticket_id: 7
', 'f', '2016-03-22 13:10:11', '2016-03-22 13:10:11', 105);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (116, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  status_updated_at: 
  - "2016-03-22"
  - "2016-03-22"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Adding Additional Users
:ticket_id: 7
', 'f', '2016-03-22 13:10:36', '2016-03-22 13:10:36', 105);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (117, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  status_updated_at: 
  - "2016-03-22"
  - "2016-03-22"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Adding Additional Users
:ticket_id: 7
', 'f', '2016-03-22 13:20:26', '2016-03-22 13:20:26', 105);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (118, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  first_sub_cat: 
  - 
  - Account Setup
  status_updated_at: 
  - "2016-03-22"
  - "2016-03-22"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Adding Additional Users
:ticket_id: 7
', 'f', '2016-03-22 13:38:16', '2016-03-22 13:38:16', 105);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (121, 'ticket_updated', '--- 
:assigned_to: Hemalatha G.
:by: Scott W.
:by_id: 4
:changes: 
  first_sub_cat: 
  - 
  - Issue
  status_updated_at: 
  - "2016-03-17"
  - "2016-03-22"
:device_ids: 
- 26
:due_at: 2016-03-24 17:00:00 -04:00
:past_due: false
:priority: Med
:related_to: Evernote
:submitter_display_name: hemalatha.gopisetty@ballistix.com
:summary: Test Ticket 1
:ticket_id: 5
', 'f', '2016-03-22 13:38:26', '2016-03-22 13:38:26', 108);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (130, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 18
:comment_name: "Ticket #8"
:ticket_id: 8
:ticket_summary: Test-Customer 271700
', 'f', '2016-03-24 13:02:22', '2016-03-24 13:02:22', 117);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (131, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test-Customer 271700
:ticket_id: 8
:to: Monty K.
:to_id: 5
', 'f', '2016-03-24 13:02:22', '2016-03-24 13:02:22', 118);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (132, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 18
:comment_name: "Ticket #8"
:ticket_id: 8
:ticket_summary: Test-Customer 271700
', 'f', '2016-03-24 13:02:22', '2016-03-24 13:02:22', 119);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (133, 'ticket_opened', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test-Customer 271700
:ticket_id: 8
', 'f', '2016-03-24 13:02:22', '2016-03-24 13:02:22', 120);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (134, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 19
:comment_name: "Ticket #9"
:ticket_id: 9
:ticket_summary: test
', 'f', '2016-03-24 13:05:38', '2016-03-24 13:05:38', 121);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (135, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 9
:to: Monty K.
:to_id: 5
', 'f', '2016-03-24 13:05:38', '2016-03-24 13:05:38', 122);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (136, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 19
:comment_name: "Ticket #9"
:ticket_id: 9
:ticket_summary: test
', 'f', '2016-03-24 13:05:38', '2016-03-24 13:05:38', 123);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (137, 'ticket_opened', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 9
', 'f', '2016-03-24 13:05:38', '2016-03-24 13:05:38', 124);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (138, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 20
:comment_name: "Ticket #9"
:ticket_id: 9
:ticket_summary: test
', 'f', '2016-03-24 13:07:05', '2016-03-24 13:07:05', 125);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (139, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 9
', 'f', '2016-03-24 13:07:06', '2016-03-24 13:07:06', 126);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (140, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 20
:comment_name: "Ticket #9"
:ticket_id: 9
:ticket_summary: test
', 'f', '2016-03-24 13:07:06', '2016-03-24 13:07:06', 127);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (141, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  status: 
  - open
  - closed
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 9
', 'f', '2016-03-24 13:07:06', '2016-03-24 13:07:06', 128);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (142, 'ticket_comment_added', '--- 
:body: |-
  $30.09/cs.
  
  Sue
:by: Sue S.
:by_id: 8
:comment_id: 21
:comment_name: "Ticket #8"
:ticket_id: 8
:ticket_summary: Test-Customer 271700
', 'f', '2016-03-24 13:11:03', '2016-03-24 13:11:03', 129);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (143, 'ticket_comment_added', '--- 
:body: |-
  $30.09/cs.
  
  Sue
:by: Sue S.
:by_id: 8
:comment_id: 21
:comment_name: "Ticket #8"
:ticket_id: 8
:ticket_summary: Test-Customer 271700
', 'f', '2016-03-24 13:11:03', '2016-03-24 13:11:03', 129);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (144, 'ticket_opened', '--- 
:assigned_to: Monty K.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test-Customer 271700
:ticket_id: 8
', 'f', '2016-03-24 13:11:03', '2016-03-24 13:11:03', 130);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (145, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 22
:comment_name: "Ticket #8"
:ticket_id: 8
:ticket_summary: Test-Customer 271700
', 'f', '2016-03-24 13:38:12', '2016-03-24 13:38:12', 131);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (146, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test-Customer 271700
:ticket_id: 8
', 'f', '2016-03-24 13:38:12', '2016-03-24 13:38:12', 132);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (147, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 22
:comment_name: "Ticket #8"
:ticket_id: 8
:ticket_summary: Test-Customer 271700
', 'f', '2016-03-24 13:38:12', '2016-03-24 13:38:12', 133);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (148, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  status: 
  - open
  - closed
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test-Customer 271700
:ticket_id: 8
', 'f', '2016-03-24 13:38:12', '2016-03-24 13:38:12', 134);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (150, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Monty K.
:by_id: 5
:comment_id: 23
:comment_name: "Ticket #10"
:ticket_id: 10
:ticket_summary: Pricing for customer
', 'f', '2016-03-24 13:53:12', '2016-03-24 13:53:12', 136);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (151, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Pricing for customer
:ticket_id: 10
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-03-24 13:53:12', '2016-03-24 13:53:12', 137);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (152, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Monty K.
:by_id: 5
:comment_id: 23
:comment_name: "Ticket #10"
:ticket_id: 10
:ticket_summary: Pricing for customer
', 'f', '2016-03-24 13:53:12', '2016-03-24 13:53:12', 138);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (153, 'ticket_opened', '--- 
:assigned_to: Elizabeth H.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Pricing for customer
:ticket_id: 10
', 'f', '2016-03-24 13:53:12', '2016-03-24 13:53:12', 139);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (154, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Scott W.
:by_id: 4
:comment_id: 24
:comment_name: "Ticket #11"
:ticket_id: 11
:ticket_summary: Order some awesome stuff for me
', 'f', '2016-03-24 13:54:04', '2016-03-24 13:54:04', 140);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (155, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Scott W.
:by_id: 4
:comment_id: 24
:comment_name: "Ticket #11"
:ticket_id: 11
:ticket_summary: Order some awesome stuff for me
', 'f', '2016-03-24 13:54:04', '2016-03-24 13:54:04', 140);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (156, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Scott W.
:by_id: 4
:comment_id: 24
:comment_name: "Ticket #11"
:ticket_id: 11
:ticket_summary: Order some awesome stuff for me
', 'f', '2016-03-24 13:54:04', '2016-03-24 13:54:04', 140);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (157, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Order some awesome stuff for me
:ticket_id: 11
', 'f', '2016-03-24 13:54:05', '2016-03-24 13:54:05', 141);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (158, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 25
:comment_name: "Ticket #11"
:ticket_id: 11
:ticket_summary: Order some awesome stuff for me
', 'f', '2016-03-24 13:54:45', '2016-03-24 13:54:45', 142);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (159, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Order some awesome stuff for me
:ticket_id: 11
:to: Monty K.
:to_id: 5
', 'f', '2016-03-24 13:54:45', '2016-03-24 13:54:45', 143);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (160, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 25
:comment_name: "Ticket #11"
:ticket_id: 11
:ticket_summary: Order some awesome stuff for me
', 'f', '2016-03-24 13:54:45', '2016-03-24 13:54:45', 144);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (161, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Order some awesome stuff for me
:ticket_id: 11
', 'f', '2016-03-24 13:54:45', '2016-03-24 13:54:45', 145);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (162, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Monty K.
:by_id: 5
:comment_id: 26
:comment_name: "Ticket #11"
:ticket_id: 11
:ticket_summary: Order some awesome stuff for me
', 'f', '2016-03-24 13:55:12', '2016-03-24 13:55:12', 146);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (163, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Order some awesome stuff for me
:ticket_id: 11
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-03-24 13:55:13', '2016-03-24 13:55:13', 147);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (164, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Monty K.
:by_id: 5
:comment_id: 26
:comment_name: "Ticket #11"
:ticket_id: 11
:ticket_summary: Order some awesome stuff for me
', 'f', '2016-03-24 13:55:13', '2016-03-24 13:55:13', 148);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (165, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Order some awesome stuff for me
:ticket_id: 11
', 'f', '2016-03-24 13:55:13', '2016-03-24 13:55:13', 149);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (166, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Customer Service
  first_sub_cat: 
  - 
  - Customer Service
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Order some awesome stuff for me
:ticket_id: 11
', 'f', '2016-03-24 13:55:27', '2016-03-24 13:55:27', 149);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (167, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Monty K.
:by_id: 5
:changes: 
  second_sub_cat: 
  - 
  - Order Entry
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Order some awesome stuff for me
:ticket_id: 11
', 'f', '2016-03-24 13:55:31', '2016-03-24 13:55:31', 149);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (168, 'ticket_comment_added', '--- 
:body: Order complete.  Order number 272727272
:by: Monty K.
:by_id: 5
:comment_id: 27
:comment_name: "Ticket #11"
:ticket_id: 11
:ticket_summary: Order some awesome stuff for me
', 'f', '2016-03-24 13:57:40', '2016-03-24 13:57:40', 150);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (169, 'ticket_comment_added', '--- 
:body: Order complete.  Order number 272727272
:by: Monty K.
:by_id: 5
:comment_id: 27
:comment_name: "Ticket #11"
:ticket_id: 11
:ticket_summary: Order some awesome stuff for me
', 'f', '2016-03-24 13:57:40', '2016-03-24 13:57:40', 150);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (170, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 28
:comment_name: "Ticket #11"
:ticket_id: 11
:ticket_summary: Order some awesome stuff for me
', 'f', '2016-03-24 13:58:10', '2016-03-24 13:58:10', 150);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (171, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Order some awesome stuff for me
:ticket_id: 11
', 'f', '2016-03-24 13:58:10', '2016-03-24 13:58:10', 151);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (172, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 28
:comment_name: "Ticket #11"
:ticket_id: 11
:ticket_summary: Order some awesome stuff for me
', 'f', '2016-03-24 13:58:10', '2016-03-24 13:58:10', 152);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (173, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Order some awesome stuff for me
:ticket_id: 11
', 'f', '2016-03-24 13:58:10', '2016-03-24 13:58:10', 153);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (174, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Georgia-Pacific Credit Approved for Claim 0201053809
:ticket_id: 12
', 'f', '2016-03-24 14:17:03', '2016-03-24 14:17:03', 154);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (175, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Scott W.
:by_id: 4
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Georgia-Pacific Credit Approved for Claim 0201053809
:ticket_id: 12
', 'f', '2016-03-24 14:17:17', '2016-03-24 14:17:17', 155);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (176, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Scott W.
:by_id: 4
:changes: 
  category: 
  - Unspecified
  - Customer Service
  first_sub_cat: 
  - Unspecified
  - Customer Service
  second_sub_cat: 
  - 
  - Order Entry
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Georgia-Pacific Credit Approved for Claim 0201053809
:ticket_id: 12
', 'f', '2016-03-24 14:17:35', '2016-03-24 14:17:35', 155);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (177, 'ticket_comment_added', '--- 
:body: Assigned to Scott Whitson.
:by: Scott W.
:by_id: 4
:comment_id: 29
:comment_name: "Ticket #12"
:ticket_id: 12
:ticket_summary: Georgia-Pacific Credit Approved for Claim 0201053809
', 'f', '2016-03-24 14:17:39', '2016-03-24 14:17:39', 156);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (178, 'ticket_reassigned', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Georgia-Pacific Credit Approved for Claim 0201053809
:ticket_id: 12
:to: Scott W.
:to_id: 4
', 'f', '2016-03-24 14:17:39', '2016-03-24 14:17:39', 157);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (179, 'ticket_comment_added', '--- 
:body: Assigned to Scott Whitson.
:by: Scott W.
:by_id: 4
:comment_id: 29
:comment_name: "Ticket #12"
:ticket_id: 12
:ticket_summary: Georgia-Pacific Credit Approved for Claim 0201053809
', 'f', '2016-03-24 14:17:39', '2016-03-24 14:17:39', 158);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (180, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Georgia-Pacific Credit Approved for Claim 0201053809
:ticket_id: 12
', 'f', '2016-03-24 14:17:39', '2016-03-24 14:17:39', 159);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (181, 'ticket_comment_added', '--- 
:body: "Ticket closed: Order is entered - 2727272-00"
:by: Scott W.
:by_id: 4
:comment_id: 30
:comment_name: "Ticket #12"
:ticket_id: 12
:ticket_summary: Georgia-Pacific Credit Approved for Claim 0201053809
', 'f', '2016-03-24 14:18:01', '2016-03-24 14:18:01', 160);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (182, 'ticket_closed', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:email: swhitson@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Georgia-Pacific Credit Approved for Claim 0201053809
:ticket_id: 12
', 'f', '2016-03-24 14:18:01', '2016-03-24 14:18:01', 161);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (183, 'ticket_comment_added', '--- 
:body: "Ticket closed: Order is entered - 2727272-00"
:by: Scott W.
:by_id: 4
:comment_id: 30
:comment_name: "Ticket #12"
:ticket_id: 12
:ticket_summary: Georgia-Pacific Credit Approved for Claim 0201053809
', 'f', '2016-03-24 14:18:01', '2016-03-24 14:18:01', 162);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (184, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Scott W.
:by_id: 4
:changes: 
  category: 
  - 
  - Customer Service
  first_sub_cat: 
  - 
  - Customer Service
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Pricing for customer
:ticket_id: 10
', 'f', '2016-03-24 14:18:55', '2016-03-24 14:18:55', 163);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (185, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Scott W.
:by_id: 4
:changes: 
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Pricing for customer
:ticket_id: 10
', 'f', '2016-03-24 14:20:06', '2016-03-24 14:20:06', 163);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (187, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 31
:comment_name: "Ticket #13"
:ticket_id: 13
:ticket_summary: PO80061749
', 'f', '2016-03-24 14:37:03', '2016-03-24 14:37:03', 165);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (188, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 31
:comment_name: "Ticket #13"
:ticket_id: 13
:ticket_summary: PO80061749
', 'f', '2016-03-24 14:37:03', '2016-03-24 14:37:03', 165);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (189, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 31
:comment_name: "Ticket #13"
:ticket_id: 13
:ticket_summary: PO80061749
', 'f', '2016-03-24 14:37:03', '2016-03-24 14:37:03', 165);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (190, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: PO80061749
:ticket_id: 13
', 'f', '2016-03-24 14:37:04', '2016-03-24 14:37:04', 166);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (191, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 32
:comment_name: "Ticket #14"
:ticket_id: 14
:ticket_summary: PO80061744, PO80061745, PO80061746
', 'f', '2016-03-24 14:39:03', '2016-03-24 14:39:03', 167);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (192, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 32
:comment_name: "Ticket #14"
:ticket_id: 14
:ticket_summary: PO80061744, PO80061745, PO80061746
', 'f', '2016-03-24 14:39:03', '2016-03-24 14:39:03', 167);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (193, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 32
:comment_name: "Ticket #14"
:ticket_id: 14
:ticket_summary: PO80061744, PO80061745, PO80061746
', 'f', '2016-03-24 14:39:03', '2016-03-24 14:39:03', 167);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (194, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 32
:comment_name: "Ticket #14"
:ticket_id: 14
:ticket_summary: PO80061744, PO80061745, PO80061746
', 'f', '2016-03-24 14:39:03', '2016-03-24 14:39:03', 167);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (195, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: PO80061744, PO80061745, PO80061746
:ticket_id: 14
', 'f', '2016-03-24 14:39:03', '2016-03-24 14:39:03', 168);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (196, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 34
:comment_name: "Ticket #15"
:ticket_id: 15
:ticket_summary: Help
', 'f', '2016-03-24 14:40:03', '2016-03-24 14:40:03', 169);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (197, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 34
:comment_name: "Ticket #15"
:ticket_id: 15
:ticket_summary: Help
', 'f', '2016-03-24 14:40:03', '2016-03-24 14:40:03', 169);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (198, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 34
:comment_name: "Ticket #15"
:ticket_id: 15
:ticket_summary: Help
', 'f', '2016-03-24 14:40:03', '2016-03-24 14:40:03', 169);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (199, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Help
:ticket_id: 15
', 'f', '2016-03-24 14:40:04', '2016-03-24 14:40:04', 170);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (200, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 35
:comment_name: "Ticket #16"
:ticket_id: 16
:ticket_summary: 16-337803
', 'f', '2016-03-24 14:40:20', '2016-03-24 14:40:20', 171);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (201, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 35
:comment_name: "Ticket #16"
:ticket_id: 16
:ticket_summary: 16-337803
', 'f', '2016-03-24 14:40:20', '2016-03-24 14:40:20', 171);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (202, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 35
:comment_name: "Ticket #16"
:ticket_id: 16
:ticket_summary: 16-337803
', 'f', '2016-03-24 14:40:20', '2016-03-24 14:40:20', 171);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (203, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: 16-337803
:ticket_id: 16
', 'f', '2016-03-24 14:40:20', '2016-03-24 14:40:20', 172);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (204, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Scott W.
:by_id: 4
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: 16-337803
:ticket_id: 16
', 'f', '2016-03-24 14:40:45', '2016-03-24 14:40:45', 173);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (205, 'ticket_comment_added', '--- 
:body: Test complete.  Time to try this out for reals"ish"
:by: Elizabeth H.
:by_id: 9
:comment_id: 36
:comment_name: "Ticket #10"
:ticket_id: 10
:ticket_summary: Pricing for customer
', 'f', '2016-03-24 14:43:08', '2016-03-24 14:43:08', 174);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (206, 'ticket_comment_added', '--- 
:body: Test complete.  Time to try this out for reals"ish"
:by: Elizabeth H.
:by_id: 9
:comment_id: 36
:comment_name: "Ticket #10"
:ticket_id: 10
:ticket_summary: Pricing for customer
', 'f', '2016-03-24 14:43:08', '2016-03-24 14:43:08', 174);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (207, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 37
:comment_name: "Ticket #10"
:ticket_id: 10
:ticket_summary: Pricing for customer
', 'f', '2016-03-24 14:43:15', '2016-03-24 14:43:15', 174);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (208, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Pricing for customer
:ticket_id: 10
', 'f', '2016-03-24 14:43:16', '2016-03-24 14:43:16', 175);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (209, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 37
:comment_name: "Ticket #10"
:ticket_id: 10
:ticket_summary: Pricing for customer
', 'f', '2016-03-24 14:43:16', '2016-03-24 14:43:16', 176);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (210, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Pricing for customer
:ticket_id: 10
', 'f', '2016-03-24 14:43:16', '2016-03-24 14:43:16', 177);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (211, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 38
:comment_name: "Ticket #13"
:ticket_id: 13
:ticket_summary: PO80061749
', 'f', '2016-03-24 14:43:18', '2016-03-24 14:43:18', 178);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (212, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: PO80061749
:ticket_id: 13
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-03-24 14:43:19', '2016-03-24 14:43:19', 179);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (213, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 38
:comment_name: "Ticket #13"
:ticket_id: 13
:ticket_summary: PO80061749
', 'f', '2016-03-24 14:43:19', '2016-03-24 14:43:19', 180);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (214, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: PO80061749
:ticket_id: 13
', 'f', '2016-03-24 14:43:19', '2016-03-24 14:43:19', 181);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (215, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 39
:comment_name: "Ticket #14"
:ticket_id: 14
:ticket_summary: PO80061744, PO80061745, PO80061746
', 'f', '2016-03-24 14:43:20', '2016-03-24 14:43:20', 182);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (216, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: PO80061744, PO80061745, PO80061746
:ticket_id: 14
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-03-24 14:43:20', '2016-03-24 14:43:20', 183);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (217, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 39
:comment_name: "Ticket #14"
:ticket_id: 14
:ticket_summary: PO80061744, PO80061745, PO80061746
', 'f', '2016-03-24 14:43:20', '2016-03-24 14:43:20', 184);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (218, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: PO80061744, PO80061745, PO80061746
:ticket_id: 14
', 'f', '2016-03-24 14:43:21', '2016-03-24 14:43:21', 185);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (219, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 40
:comment_name: "Ticket #15"
:ticket_id: 15
:ticket_summary: Help
', 'f', '2016-03-24 14:43:30', '2016-03-24 14:43:30', 186);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (220, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Help
:ticket_id: 15
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-03-24 14:43:30', '2016-03-24 14:43:30', 187);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (221, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 40
:comment_name: "Ticket #15"
:ticket_id: 15
:ticket_summary: Help
', 'f', '2016-03-24 14:43:30', '2016-03-24 14:43:30', 188);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (222, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Help
:ticket_id: 15
', 'f', '2016-03-24 14:43:30', '2016-03-24 14:43:30', 189);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (223, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 41
:comment_name: "Ticket #16"
:ticket_id: 16
:ticket_summary: 16-337803
', 'f', '2016-03-24 14:43:33', '2016-03-24 14:43:33', 190);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (224, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: 16-337803
:ticket_id: 16
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-03-24 14:43:33', '2016-03-24 14:43:33', 191);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (225, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 41
:comment_name: "Ticket #16"
:ticket_id: 16
:ticket_summary: 16-337803
', 'f', '2016-03-24 14:43:33', '2016-03-24 14:43:33', 192);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (226, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: 16-337803
:ticket_id: 16
', 'f', '2016-03-24 14:43:33', '2016-03-24 14:43:33', 193);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (227, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 42
:comment_name: "Ticket #13"
:ticket_id: 13
:ticket_summary: PO80061749
', 'f', '2016-03-24 14:45:43', '2016-03-24 14:45:43', 194);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (228, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: PO80061749
:ticket_id: 13
', 'f', '2016-03-24 14:45:43', '2016-03-24 14:45:43', 195);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (229, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 42
:comment_name: "Ticket #13"
:ticket_id: 13
:ticket_summary: PO80061749
', 'f', '2016-03-24 14:45:43', '2016-03-24 14:45:43', 196);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (230, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: PO80061749
:ticket_id: 13
', 'f', '2016-03-24 14:45:43', '2016-03-24 14:45:43', 197);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (231, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Sue S.
:by_id: 8
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: PO80061744, PO80061745, PO80061746
:ticket_id: 14
', 'f', '2016-03-24 14:48:35', '2016-03-24 14:48:35', 197);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (232, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 43
:comment_name: "Ticket #14"
:ticket_id: 14
:ticket_summary: PO80061744, PO80061745, PO80061746
', 'f', '2016-03-24 15:12:49', '2016-03-24 15:12:49', 198);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (233, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: PO80061744, PO80061745, PO80061746
:ticket_id: 14
', 'f', '2016-03-24 15:12:49', '2016-03-24 15:12:49', 199);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (234, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 43
:comment_name: "Ticket #14"
:ticket_id: 14
:ticket_summary: PO80061744, PO80061745, PO80061746
', 'f', '2016-03-24 15:12:49', '2016-03-24 15:12:49', 200);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (235, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: PO80061744, PO80061745, PO80061746
:ticket_id: 14
', 'f', '2016-03-24 15:12:49', '2016-03-24 15:12:49', 201);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (236, 'ticket_comment_added', '--- 
:body: Complete
:by: Elizabeth H.
:by_id: 9
:comment_id: 44
:comment_name: "Ticket #16"
:ticket_id: 16
:ticket_summary: 16-337803
', 'f', '2016-03-24 15:17:03', '2016-03-24 15:17:03', 202);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (237, 'ticket_comment_added', '--- 
:body: Complete
:by: Elizabeth H.
:by_id: 9
:comment_id: 44
:comment_name: "Ticket #16"
:ticket_id: 16
:ticket_summary: 16-337803
', 'f', '2016-03-24 15:17:03', '2016-03-24 15:17:03', 202);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (238, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 45
:comment_name: "Ticket #16"
:ticket_id: 16
:ticket_summary: 16-337803
', 'f', '2016-03-24 15:17:07', '2016-03-24 15:17:07', 202);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (239, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: 16-337803
:ticket_id: 16
', 'f', '2016-03-24 15:17:07', '2016-03-24 15:17:07', 203);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (240, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 45
:comment_name: "Ticket #16"
:ticket_id: 16
:ticket_summary: 16-337803
', 'f', '2016-03-24 15:17:07', '2016-03-24 15:17:07', 204);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (241, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: 16-337803
:ticket_id: 16
', 'f', '2016-03-24 15:17:08', '2016-03-24 15:17:08', 205);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (242, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - 
  - Customer Service
  first_sub_cat: 
  - 
  - Customer Service
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Help
:ticket_id: 15
', 'f', '2016-03-24 15:23:17', '2016-03-24 15:23:17', 205);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (243, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  second_sub_cat: 
  - 
  - Order Entry
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Help
:ticket_id: 15
', 'f', '2016-03-24 15:23:17', '2016-03-24 15:23:17', 205);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (244, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Help
:ticket_id: 15
', 'f', '2016-03-24 15:23:19', '2016-03-24 15:23:19', 205);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (245, 'ticket_comment_added', '--- 
:body: entered order per mikes request
:by: Elizabeth H.
:by_id: 9
:comment_id: 46
:comment_name: "Ticket #15"
:ticket_id: 15
:ticket_summary: Help
', 'f', '2016-03-24 15:23:20', '2016-03-24 15:23:20', 206);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (246, 'ticket_comment_added', '--- 
:body: entered order per mikes request
:by: Elizabeth H.
:by_id: 9
:comment_id: 46
:comment_name: "Ticket #15"
:ticket_id: 15
:ticket_summary: Help
', 'f', '2016-03-24 15:23:21', '2016-03-24 15:23:21', 206);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (247, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  second_sub_cat: 
  - Order Entry
  - 
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Help
:ticket_id: 15
', 'f', '2016-03-24 15:23:22', '2016-03-24 15:23:22', 207);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (248, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  second_sub_cat: 
  - 
  - Order Entry
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Help
:ticket_id: 15
', 'f', '2016-03-24 15:23:23', '2016-03-24 15:23:23', 207);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (249, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Help
:ticket_id: 15
', 'f', '2016-03-24 15:29:11', '2016-03-24 15:29:11', 207);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (250, 'ticket_comment_added', '--- 
:body: entered
:by: Elizabeth H.
:by_id: 9
:comment_id: 47
:comment_name: "Ticket #15"
:ticket_id: 15
:ticket_summary: Help
', 'f', '2016-03-24 15:29:15', '2016-03-24 15:29:15', 208);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (251, 'ticket_comment_added', '--- 
:body: entered
:by: Elizabeth H.
:by_id: 9
:comment_id: 47
:comment_name: "Ticket #15"
:ticket_id: 15
:ticket_summary: Help
', 'f', '2016-03-24 15:29:15', '2016-03-24 15:29:15', 208);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (252, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 48
:comment_name: "Ticket #15"
:ticket_id: 15
:ticket_summary: Help
', 'f', '2016-03-24 15:29:22', '2016-03-24 15:29:22', 208);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (253, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Help
:ticket_id: 15
', 'f', '2016-03-24 15:29:22', '2016-03-24 15:29:22', 209);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (254, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 48
:comment_name: "Ticket #15"
:ticket_id: 15
:ticket_summary: Help
', 'f', '2016-03-24 15:29:22', '2016-03-24 15:29:22', 210);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (255, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Help
:ticket_id: 15
', 'f', '2016-03-24 15:29:22', '2016-03-24 15:29:22', 211);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (256, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 49
:comment_name: "Ticket #17"
:ticket_id: 17
:ticket_summary: Connect With Us [#569]
', 'f', '2016-03-24 15:31:03', '2016-03-24 15:31:03', 212);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (257, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 49
:comment_name: "Ticket #17"
:ticket_id: 17
:ticket_summary: Connect With Us [#569]
', 'f', '2016-03-24 15:31:03', '2016-03-24 15:31:03', 212);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (258, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 49
:comment_name: "Ticket #17"
:ticket_id: 17
:ticket_summary: Connect With Us [#569]
', 'f', '2016-03-24 15:31:03', '2016-03-24 15:31:03', 212);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (259, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 49
:comment_name: "Ticket #17"
:ticket_id: 17
:ticket_summary: Connect With Us [#569]
', 'f', '2016-03-24 15:31:03', '2016-03-24 15:31:03', 212);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (260, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Connect With Us [#569]
:ticket_id: 17
', 'f', '2016-03-24 15:31:03', '2016-03-24 15:31:03', 213);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (261, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - 
  - Customer Service
  first_sub_cat: 
  - 
  - Customer Service
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Connect With Us [#569]
:ticket_id: 17
', 'f', '2016-03-24 15:32:31', '2016-03-24 15:32:31', 214);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (262, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Connect With Us [#569]
:ticket_id: 17
', 'f', '2016-03-24 15:33:01', '2016-03-24 15:33:01', 214);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (263, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - Customer Service
  - Pricing
  first_sub_cat: 
  - Customer Service
  - Pricing
  second_sub_cat: 
  - 
  - Set Up Price
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Connect With Us [#569]
:ticket_id: 17
', 'f', '2016-03-24 15:33:06', '2016-03-24 15:33:06', 214);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (264, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Sue S.
:by_id: 8
:comment_id: 51
:comment_name: "Ticket #18"
:ticket_id: 18
:ticket_summary: Price Request
', 'f', '2016-03-24 15:34:44', '2016-03-24 15:34:44', 215);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (265, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Sue S.
:by_id: 8
:comment_id: 51
:comment_name: "Ticket #18"
:ticket_id: 18
:ticket_summary: Price Request
', 'f', '2016-03-24 15:34:44', '2016-03-24 15:34:44', 215);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (266, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Sue S.
:by_id: 8
:comment_id: 51
:comment_name: "Ticket #18"
:ticket_id: 18
:ticket_summary: Price Request
', 'f', '2016-03-24 15:34:44', '2016-03-24 15:34:44', 215);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (267, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Price Request
:ticket_id: 18
', 'f', '2016-03-24 15:34:44', '2016-03-24 15:34:44', 216);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (268, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Sue S.
:by_id: 8
:comment_id: 52
:comment_name: "Ticket #18"
:ticket_id: 18
:ticket_summary: Price Request
', 'f', '2016-03-24 15:35:03', '2016-03-24 15:35:03', 217);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (269, 'ticket_reassigned', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Price Request
:ticket_id: 18
:to: Sue S.
:to_id: 8
', 'f', '2016-03-24 15:35:03', '2016-03-24 15:35:03', 218);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (270, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Sue S.
:by_id: 8
:comment_id: 52
:comment_name: "Ticket #18"
:ticket_id: 18
:ticket_summary: Price Request
', 'f', '2016-03-24 15:35:03', '2016-03-24 15:35:03', 219);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (271, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:changes: 
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Price Request
:ticket_id: 18
', 'f', '2016-03-24 15:35:03', '2016-03-24 15:35:03', 220);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (272, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Sue S.
:by_id: 8
:comment_id: 53
:comment_name: "Ticket #18"
:ticket_id: 18
:ticket_summary: Price Request
', 'f', '2016-03-24 15:35:06', '2016-03-24 15:35:06', 221);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (273, 'ticket_closed', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:email: sstapleton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Price Request
:ticket_id: 18
', 'f', '2016-03-24 15:35:06', '2016-03-24 15:35:06', 222);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (274, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Sue S.
:by_id: 8
:comment_id: 53
:comment_name: "Ticket #18"
:ticket_id: 18
:ticket_summary: Price Request
', 'f', '2016-03-24 15:35:06', '2016-03-24 15:35:06', 223);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (275, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Price Request
:ticket_id: 18
', 'f', '2016-03-24 15:35:06', '2016-03-24 15:35:06', 224);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (276, 'ticket_comment_added', '--- 
:body: "Ticket closed: quote request from the website (#569).  Customer inactive since 2005.  Sent link to app and quote for windex only.   Advised need more info to see if we have towel that will work."
:by: Elizabeth H.
:by_id: 9
:comment_id: 54
:comment_name: "Ticket #17"
:ticket_id: 17
:ticket_summary: Connect With Us [#569]
', 'f', '2016-03-24 15:44:49', '2016-03-24 15:44:49', 225);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (277, 'ticket_comment_added', '--- 
:body: "Ticket closed: quote request from the website (#569).  Customer inactive since 2005.  Sent link to app and quote for windex only.   Advised need more info to see if we have towel that will work."
:by: Elizabeth H.
:by_id: 9
:comment_id: 54
:comment_name: "Ticket #17"
:ticket_id: 17
:ticket_summary: Connect With Us [#569]
', 'f', '2016-03-24 15:44:49', '2016-03-24 15:44:49', 225);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (278, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Connect With Us [#569]
:ticket_id: 17
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-03-24 15:44:50', '2016-03-24 15:44:50', 226);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (279, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: Connect With Us [#569]
:ticket_id: 17
', 'f', '2016-03-24 15:44:50', '2016-03-24 15:44:50', 227);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (280, 'ticket_comment_added', '--- 
:body: "Ticket closed: quote request from the website (#569).  Customer inactive since 2005.  Sent link to app and quote for windex only.   Advised need more info to see if we have towel that will work."
:by: Elizabeth H.
:by_id: 9
:comment_id: 54
:comment_name: "Ticket #17"
:ticket_id: 17
:ticket_summary: Connect With Us [#569]
', 'f', '2016-03-24 15:44:50', '2016-03-24 15:44:50', 228);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (281, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Custom Foods - Justin Brandon
:ticket_id: 19
', 'f', '2016-03-24 15:53:03', '2016-03-24 15:53:03', 229);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (282, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Scott W.
:by_id: 4
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Custom Foods - Justin Brandon
:ticket_id: 19
', 'f', '2016-03-24 15:55:14', '2016-03-24 15:55:14', 230);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (283, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 56
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 15:57:04', '2016-03-24 15:57:04', 231);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (284, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 56
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 15:57:04', '2016-03-24 15:57:04', 231);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (285, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 56
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 15:57:04', '2016-03-24 15:57:04', 231);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (286, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Elizabeth H.
:by_id: 9
:comment_id: 56
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 15:57:04', '2016-03-24 15:57:04', 231);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (287, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: TEst
:ticket_id: 20
', 'f', '2016-03-24 15:57:04', '2016-03-24 15:57:04', 232);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (288, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 58
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 15:57:35', '2016-03-24 15:57:35', 233);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (289, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: TEst
:ticket_id: 20
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-03-24 15:57:35', '2016-03-24 15:57:35', 234);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (290, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 58
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 15:57:35', '2016-03-24 15:57:35', 235);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (291, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: TEst
:ticket_id: 20
', 'f', '2016-03-24 15:57:36', '2016-03-24 15:57:36', 236);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (292, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - 
  - Customer Service
  first_sub_cat: 
  - 
  - Customer Service
  second_sub_cat: 
  - 
  - Order Entry
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: TEst
:ticket_id: 20
', 'f', '2016-03-24 15:57:49', '2016-03-24 15:57:49', 236);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (293, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 59
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 15:58:12', '2016-03-24 15:58:12', 237);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (294, 'ticket_reassigned', '--- 
:assigned_to: Sue S.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: TEst
:ticket_id: 20
:to: Sue S.
:to_id: 8
', 'f', '2016-03-24 15:58:12', '2016-03-24 15:58:12', 238);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (295, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 59
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 15:58:12', '2016-03-24 15:58:12', 239);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (296, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: TEst
:ticket_id: 20
', 'f', '2016-03-24 15:58:12', '2016-03-24 15:58:12', 240);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (297, 'ticket_comment_added', '--- 
:body: checking to see if I can re-assign to sue
:by: Elizabeth H.
:by_id: 9
:comment_id: 60
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 15:58:14', '2016-03-24 15:58:14', 241);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (298, 'ticket_comment_added', '--- 
:body: checking to see if I can re-assign to sue
:by: Elizabeth H.
:by_id: 9
:comment_id: 60
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 15:58:14', '2016-03-24 15:58:14', 241);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (299, 'user_created', '--- 
:source: :user
:user_email: jbales@kelsan.biz
:user_id: 11
', 'f', '2016-03-24 16:00:04', '2016-03-24 16:00:04', 242);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (300, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Sue S.
:by_id: 8
:comment_id: 61
:comment_name: "Ticket #21"
:ticket_id: 21
:ticket_summary: Kelsan Acknowledgement 2689706-00
', 'f', '2016-03-24 16:00:04', '2016-03-24 16:00:04', 243);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (301, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Sue S.
:by_id: 8
:comment_id: 61
:comment_name: "Ticket #21"
:ticket_id: 21
:ticket_summary: Kelsan Acknowledgement 2689706-00
', 'f', '2016-03-24 16:00:04', '2016-03-24 16:00:04', 243);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (302, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Sue S.
:by_id: 8
:comment_id: 61
:comment_name: "Ticket #21"
:ticket_id: 21
:ticket_summary: Kelsan Acknowledgement 2689706-00
', 'f', '2016-03-24 16:00:04', '2016-03-24 16:00:04', 243);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (303, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Sue S.
:by_id: 8
:comment_id: 61
:comment_name: "Ticket #21"
:ticket_id: 21
:ticket_summary: Kelsan Acknowledgement 2689706-00
', 'f', '2016-03-24 16:00:04', '2016-03-24 16:00:04', 243);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (304, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Sue S.
:by_id: 8
:comment_id: 61
:comment_name: "Ticket #21"
:ticket_id: 21
:ticket_summary: Kelsan Acknowledgement 2689706-00
', 'f', '2016-03-24 16:00:04', '2016-03-24 16:00:04', 243);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (305, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Kelsan Acknowledgement 2689706-00
:ticket_id: 21
', 'f', '2016-03-24 16:00:04', '2016-03-24 16:00:04', 244);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (306, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Sue S.
:by_id: 8
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Kelsan Acknowledgement 2689706-00
:ticket_id: 21
', 'f', '2016-03-24 16:00:21', '2016-03-24 16:00:21', 245);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (307, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Sue S.
:by_id: 8
:comment_id: 63
:comment_name: "Ticket #21"
:ticket_id: 21
:ticket_summary: Kelsan Acknowledgement 2689706-00
', 'f', '2016-03-24 16:00:24', '2016-03-24 16:00:24', 246);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (308, 'ticket_reassigned', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Kelsan Acknowledgement 2689706-00
:ticket_id: 21
:to: Sue S.
:to_id: 8
', 'f', '2016-03-24 16:00:24', '2016-03-24 16:00:24', 247);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (309, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Sue S.
:by_id: 8
:comment_id: 63
:comment_name: "Ticket #21"
:ticket_id: 21
:ticket_summary: Kelsan Acknowledgement 2689706-00
', 'f', '2016-03-24 16:00:24', '2016-03-24 16:00:24', 248);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (310, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:changes: 
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Kelsan Acknowledgement 2689706-00
:ticket_id: 21
', 'f', '2016-03-24 16:00:24', '2016-03-24 16:00:24', 249);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (311, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Sue S.
:by_id: 8
:comment_id: 64
:comment_name: "Ticket #21"
:ticket_id: 21
:ticket_summary: Kelsan Acknowledgement 2689706-00
', 'f', '2016-03-24 16:00:39', '2016-03-24 16:00:39', 250);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (312, 'ticket_closed', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:email: sstapleton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Kelsan Acknowledgement 2689706-00
:ticket_id: 21
', 'f', '2016-03-24 16:00:39', '2016-03-24 16:00:39', 251);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (313, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Sue S.
:by_id: 8
:comment_id: 64
:comment_name: "Ticket #21"
:ticket_id: 21
:ticket_summary: Kelsan Acknowledgement 2689706-00
', 'f', '2016-03-24 16:00:39', '2016-03-24 16:00:39', 252);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (314, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Kelsan Acknowledgement 2689706-00
:ticket_id: 21
', 'f', '2016-03-24 16:00:39', '2016-03-24 16:00:39', 253);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (315, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Sue S.
:by_id: 8
:comment_id: 65
:comment_name: "Ticket #19"
:ticket_id: 19
:ticket_summary: Custom Foods - Justin Brandon
', 'f', '2016-03-24 16:00:51', '2016-03-24 16:00:51', 254);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (316, 'ticket_reassigned', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Custom Foods - Justin Brandon
:ticket_id: 19
:to: Sue S.
:to_id: 8
', 'f', '2016-03-24 16:00:51', '2016-03-24 16:00:51', 255);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (317, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Sue S.
:by_id: 8
:comment_id: 65
:comment_name: "Ticket #19"
:ticket_id: 19
:ticket_summary: Custom Foods - Justin Brandon
', 'f', '2016-03-24 16:00:51', '2016-03-24 16:00:51', 256);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (318, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:changes: 
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Custom Foods - Justin Brandon
:ticket_id: 19
', 'f', '2016-03-24 16:00:51', '2016-03-24 16:00:51', 257);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (319, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Sue S.
:by_id: 8
:comment_id: 66
:comment_name: "Ticket #19"
:ticket_id: 19
:ticket_summary: Custom Foods - Justin Brandon
', 'f', '2016-03-24 16:00:54', '2016-03-24 16:00:54', 258);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (320, 'ticket_closed', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:email: sstapleton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Custom Foods - Justin Brandon
:ticket_id: 19
', 'f', '2016-03-24 16:00:54', '2016-03-24 16:00:54', 259);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (321, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Sue S.
:by_id: 8
:comment_id: 66
:comment_name: "Ticket #19"
:ticket_id: 19
:ticket_summary: Custom Foods - Justin Brandon
', 'f', '2016-03-24 16:00:54', '2016-03-24 16:00:54', 260);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (322, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Custom Foods - Justin Brandon
:ticket_id: 19
', 'f', '2016-03-24 16:00:54', '2016-03-24 16:00:54', 261);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (323, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Sue S.
:by_id: 8
:comment_id: 67
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 16:02:09', '2016-03-24 16:02:09', 262);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (324, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: TEst
:ticket_id: 20
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-03-24 16:02:09', '2016-03-24 16:02:09', 263);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (325, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Sue S.
:by_id: 8
:comment_id: 67
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 16:02:09', '2016-03-24 16:02:09', 264);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (326, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Sue S.
:by_id: 8
:changes: 
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-24"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: TEst
:ticket_id: 20
', 'f', '2016-03-24 16:02:09', '2016-03-24 16:02:09', 265);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (327, 'ticket_comment_added', '--- 
:body: Elizabeth, I''m re-assigning to you!!!!!
:by: Sue S.
:by_id: 8
:comment_id: 68
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 16:02:18', '2016-03-24 16:02:18', 266);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (328, 'ticket_comment_added', '--- 
:body: Elizabeth, I''m re-assigning to you!!!!!
:by: Sue S.
:by_id: 8
:comment_id: 68
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 16:02:18', '2016-03-24 16:02:18', 266);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (331, 'ticket_comment_added', '--- 
:body: "Ticket closed: looks interesting"
:by: Elizabeth H.
:by_id: 9
:comment_id: 69
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 16:11:33', '2016-03-24 16:11:33', 269);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (332, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: TEst
:ticket_id: 20
', 'f', '2016-03-24 16:11:33', '2016-03-24 16:11:33', 270);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (333, 'ticket_comment_added', '--- 
:body: "Ticket closed: looks interesting"
:by: Elizabeth H.
:by_id: 9
:comment_id: 69
:comment_name: "Ticket #20"
:ticket_id: 20
:ticket_summary: TEst
', 'f', '2016-03-24 16:11:33', '2016-03-24 16:11:33', 271);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (337, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 70
:comment_name: "Ticket #22"
:ticket_id: 22
:ticket_summary: Test
', 'f', '2016-03-25 09:13:06', '2016-03-25 09:13:06', 275);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (338, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 70
:comment_name: "Ticket #22"
:ticket_id: 22
:ticket_summary: Test
', 'f', '2016-03-25 09:13:06', '2016-03-25 09:13:06', 275);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (339, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 70
:comment_name: "Ticket #22"
:ticket_id: 22
:ticket_summary: Test
', 'f', '2016-03-25 09:13:06', '2016-03-25 09:13:06', 275);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (340, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 22
', 'f', '2016-03-25 09:13:06', '2016-03-25 09:13:06', 276);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (341, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 71
:comment_name: "Ticket #22"
:ticket_id: 22
:ticket_summary: Test
', 'f', '2016-03-25 09:13:19', '2016-03-25 09:13:19', 277);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (342, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 22
:to: Monty K.
:to_id: 5
', 'f', '2016-03-25 09:13:19', '2016-03-25 09:13:19', 278);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (343, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 71
:comment_name: "Ticket #22"
:ticket_id: 22
:ticket_summary: Test
', 'f', '2016-03-25 09:13:19', '2016-03-25 09:13:19', 279);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (344, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - 
  - "2016-03-25"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 22
', 'f', '2016-03-25 09:13:20', '2016-03-25 09:13:20', 280);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (345, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 72
:comment_name: "Ticket #22"
:ticket_id: 22
:ticket_summary: Test
', 'f', '2016-03-25 09:13:22', '2016-03-25 09:13:22', 281);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (346, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 22
', 'f', '2016-03-25 09:13:22', '2016-03-25 09:13:22', 282);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (347, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 72
:comment_name: "Ticket #22"
:ticket_id: 22
:ticket_summary: Test
', 'f', '2016-03-25 09:13:22', '2016-03-25 09:13:22', 283);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (348, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-25"
  - "2016-03-25"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 22
', 'f', '2016-03-25 09:13:22', '2016-03-25 09:13:22', 284);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (350, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Scott W.
:by_id: 4
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - "2016-03-25"
  - "2016-03-25"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 22
', 'f', '2016-03-25 09:23:00', '2016-03-25 09:23:00', 286);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (352, 'user_created', '--- 
:source: :user
:user_email: info@em.spiceworks.com
:user_id: 12
', 'f', '2016-03-25 11:04:03', '2016-03-25 11:04:03', 288);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (353, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: info
:by_id: 12
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Downtime is coming.
:ticket_id: 23
', 'f', '2016-03-25 11:04:04', '2016-03-25 11:04:04', 289);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (354, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Sue S.
:by_id: 8
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-03-25"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Downtime is coming.
:ticket_id: 23
', 'f', '2016-03-25 13:19:29', '2016-03-25 13:19:29', 290);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (355, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Sue S.
:by_id: 8
:comment_id: 73
:comment_name: "Ticket #24"
:ticket_id: 24
:ticket_summary: Special request for Wyndham PF delivery
', 'f', '2016-03-25 13:21:05', '2016-03-25 13:21:05', 291);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (356, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Sue S.
:by_id: 8
:comment_id: 73
:comment_name: "Ticket #24"
:ticket_id: 24
:ticket_summary: Special request for Wyndham PF delivery
', 'f', '2016-03-25 13:21:06', '2016-03-25 13:21:06', 291);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (357, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Sue S.
:by_id: 8
:comment_id: 73
:comment_name: "Ticket #24"
:ticket_id: 24
:ticket_summary: Special request for Wyndham PF delivery
', 'f', '2016-03-25 13:21:06', '2016-03-25 13:21:06', 291);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (358, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Special request for Wyndham PF delivery
:ticket_id: 24
', 'f', '2016-03-25 13:21:06', '2016-03-25 13:21:06', 292);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (359, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Sue S.
:by_id: 8
:comment_id: 74
:comment_name: "Ticket #24"
:ticket_id: 24
:ticket_summary: Special request for Wyndham PF delivery
', 'f', '2016-03-25 13:56:29', '2016-03-25 13:56:29', 293);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (360, 'ticket_reassigned', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Special request for Wyndham PF delivery
:ticket_id: 24
:to: Sue S.
:to_id: 8
', 'f', '2016-03-25 13:56:29', '2016-03-25 13:56:29', 294);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (361, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Sue S.
:by_id: 8
:comment_id: 74
:comment_name: "Ticket #24"
:ticket_id: 24
:ticket_summary: Special request for Wyndham PF delivery
', 'f', '2016-03-25 13:56:29', '2016-03-25 13:56:29', 295);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (362, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:changes: 
  category: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-03-25"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Special request for Wyndham PF delivery
:ticket_id: 24
', 'f', '2016-03-25 13:56:29', '2016-03-25 13:56:29', 296);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (363, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Sue S.
:by_id: 8
:comment_id: 74
:comment_name: "Ticket #24"
:ticket_id: 24
:ticket_summary: Special request for Wyndham PF delivery
', 'f', '2016-03-25 13:56:30', '2016-03-25 13:56:30', 297);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (364, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:changes: 
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - "2016-03-25"
  - "2016-03-25"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Special request for Wyndham PF delivery
:ticket_id: 24
', 'f', '2016-03-25 13:56:30', '2016-03-25 13:56:30', 298);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (365, 'ticket_comment_added', '--- 
:body: |-
  Blue Ocean Customer failed to order before yesterday''s cut off.
  $3600.00 order, warehouse will deliver this afternoon.  Gary shared love to customer & they are very appreciative.
:by: Sue S.
:by_id: 8
:comment_id: 75
:comment_name: "Ticket #24"
:ticket_id: 24
:ticket_summary: Special request for Wyndham PF delivery
', 'f', '2016-03-25 14:00:06', '2016-03-25 14:00:06', 299);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (366, 'ticket_comment_added', '--- 
:body: |-
  Blue Ocean Customer failed to order before yesterday''s cut off.
  $3600.00 order, warehouse will deliver this afternoon.  Gary shared love to customer & they are very appreciative.
:by: Sue S.
:by_id: 8
:comment_id: 75
:comment_name: "Ticket #24"
:ticket_id: 24
:ticket_summary: Special request for Wyndham PF delivery
', 'f', '2016-03-25 14:00:06', '2016-03-25 14:00:06', 299);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (367, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Sue S.
:by_id: 8
:comment_id: 76
:comment_name: "Ticket #24"
:ticket_id: 24
:ticket_summary: Special request for Wyndham PF delivery
', 'f', '2016-03-25 14:00:25', '2016-03-25 14:00:25', 299);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (368, 'ticket_closed', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:email: sstapleton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Special request for Wyndham PF delivery
:ticket_id: 24
', 'f', '2016-03-25 14:00:25', '2016-03-25 14:00:25', 300);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (369, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Sue S.
:by_id: 8
:comment_id: 76
:comment_name: "Ticket #24"
:ticket_id: 24
:ticket_summary: Special request for Wyndham PF delivery
', 'f', '2016-03-25 14:00:25', '2016-03-25 14:00:25', 301);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (370, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-25"
  - "2016-03-25"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Special request for Wyndham PF delivery
:ticket_id: 24
', 'f', '2016-03-25 14:00:25', '2016-03-25 14:00:25', 302);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (371, 'ticket_comment_added', '--- 
:body: Assigned to Scott Whitson.
:by: Scott W.
:by_id: 4
:comment_id: 77
:comment_name: "Ticket #23"
:ticket_id: 23
:ticket_summary: Downtime is coming.
', 'f', '2016-03-29 14:44:21', '2016-03-29 14:44:21', 303);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (372, 'ticket_reassigned', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Downtime is coming.
:ticket_id: 23
:to: Scott W.
:to_id: 4
', 'f', '2016-03-29 14:44:22', '2016-03-29 14:44:22', 304);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (373, 'ticket_comment_added', '--- 
:body: Assigned to Scott Whitson.
:by: Scott W.
:by_id: 4
:comment_id: 77
:comment_name: "Ticket #23"
:ticket_id: 23
:ticket_summary: Downtime is coming.
', 'f', '2016-03-29 14:44:22', '2016-03-29 14:44:22', 305);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (374, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  status_updated_at: 
  - "2016-03-25"
  - "2016-03-29"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Downtime is coming.
:ticket_id: 23
', 'f', '2016-03-29 14:44:22', '2016-03-29 14:44:22', 306);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (375, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Scott W.
:by_id: 4
:comment_id: 78
:comment_name: "Ticket #23"
:ticket_id: 23
:ticket_summary: Downtime is coming.
', 'f', '2016-03-29 14:44:31', '2016-03-29 14:44:31', 307);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (376, 'ticket_closed', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:email: swhitson@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Downtime is coming.
:ticket_id: 23
', 'f', '2016-03-29 14:44:31', '2016-03-29 14:44:31', 308);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (377, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Scott W.
:by_id: 4
:comment_id: 78
:comment_name: "Ticket #23"
:ticket_id: 23
:ticket_summary: Downtime is coming.
', 'f', '2016-03-29 14:44:31', '2016-03-29 14:44:31', 309);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (378, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-29"
  - "2016-03-29"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Downtime is coming.
:ticket_id: 23
', 'f', '2016-03-29 14:44:31', '2016-03-29 14:44:31', 310);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (379, 'user_created', '--- 
:by: Scott W.
:by_id: 4
:source: :user
:user_email: lburke@kelsan.biz
:user_id: 13
', 'f', '2016-03-29 14:45:37', '2016-03-29 14:45:37', 311);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (380, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: cpetree@kelsan.biz
:user_id: 14
', 'f', '2016-03-29 14:57:40', '2016-03-29 14:57:40', 311);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (381, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: ctrevathan@kelsan.biz
:user_id: 15
', 'f', '2016-03-29 14:58:07', '2016-03-29 14:58:07', 311);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (382, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: sabner@kelsan.biz
:user_id: 16
', 'f', '2016-03-29 14:58:29', '2016-03-29 14:58:29', 311);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (383, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: kmahoney@kelsan.biz
:user_id: 17
', 'f', '2016-03-29 14:58:52', '2016-03-29 14:58:52', 311);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (384, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: dtate@kelsan.biz
:user_id: 18
', 'f', '2016-03-29 14:59:18', '2016-03-29 14:59:18', 311);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (385, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: tfarmer@kelsan.biz
:user_id: 19
', 'f', '2016-03-29 14:59:38', '2016-03-29 14:59:38', 311);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (386, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: redrosolano@kelsan.biz
:user_id: 20
', 'f', '2016-03-29 15:00:07', '2016-03-29 15:00:07', 311);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (387, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: cbibb@kelsan.biz
:user_id: 21
', 'f', '2016-03-29 15:00:40', '2016-03-29 15:00:40', 311);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (391, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Sue S.
:by_id: 8
:comment_id: 79
:comment_name: "Ticket #25"
:ticket_id: 25
:ticket_summary: Hospital Operations UT
', 'f', '2016-03-29 15:43:41', '2016-03-29 15:43:41', 315);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (392, 'ticket_reassigned', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 2016-03-30 17:00:00 -04:00
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Hospital Operations UT
:ticket_id: 25
:to: Sue S.
:to_id: 8
', 'f', '2016-03-29 15:43:41', '2016-03-29 15:43:41', 316);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (393, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Sue S.
:by_id: 8
:comment_id: 79
:comment_name: "Ticket #25"
:ticket_id: 25
:ticket_summary: Hospital Operations UT
', 'f', '2016-03-29 15:43:41', '2016-03-29 15:43:41', 317);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (394, 'ticket_opened', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 2016-03-30 17:00:00 -04:00
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Hospital Operations UT
:ticket_id: 25
', 'f', '2016-03-29 15:43:41', '2016-03-29 15:43:41', 318);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (399, 'ticket_comment_added', '--- 
:body: UT confirmed double shipment.  Will keep products, Nick will create invoice.  Per Deb Nelson - UT.
:by: Sue S.
:by_id: 8
:comment_id: 80
:comment_name: "Ticket #25"
:ticket_id: 25
:ticket_summary: Hospital Operations UT
', 'f', '2016-03-30 08:56:10', '2016-03-30 08:56:10', 323);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (401, 'ticket_comment_added', '--- 
:body: UT confirmed double shipment.  Will keep products, Nick will create invoice.  Per Deb Nelson - UT.
:by: Sue S.
:by_id: 8
:comment_id: 80
:comment_name: "Ticket #25"
:ticket_id: 25
:ticket_summary: Hospital Operations UT
', 'f', '2016-03-30 08:56:10', '2016-03-30 08:56:10', 325);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (402, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Sue S.
:by_id: 8
:comment_id: 81
:comment_name: "Ticket #25"
:ticket_id: 25
:ticket_summary: Hospital Operations UT
', 'f', '2016-03-30 08:56:27', '2016-03-30 08:56:27', 325);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (403, 'ticket_closed', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 2016-03-30 17:00:00 -04:00
:email: sstapleton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Hospital Operations UT
:ticket_id: 25
', 'f', '2016-03-30 08:56:28', '2016-03-30 08:56:28', 326);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (404, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Sue S.
:by_id: 8
:comment_id: 81
:comment_name: "Ticket #25"
:ticket_id: 25
:ticket_summary: Hospital Operations UT
', 'f', '2016-03-30 08:56:28', '2016-03-30 08:56:28', 327);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (405, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - 
  - "2016-03-30"
:device_ids: []

:due_at: 2016-03-30 17:00:00 -04:00
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: sstapleton@kelsan.biz
:summary: Hospital Operations UT
:ticket_id: 25
', 'f', '2016-03-30 08:56:28', '2016-03-30 08:56:28', 328);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (406, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: jstec@kelsan.biz
:user_id: 22
', 'f', '2016-03-30 13:02:48', '2016-03-30 13:02:48', 329);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (407, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: cmansfield@kelsan.biz
:user_id: 23
', 'f', '2016-03-30 13:03:36', '2016-03-30 13:03:36', 329);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (408, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: jhughes@kelsan.biz
:user_id: 24
', 'f', '2016-03-30 13:04:07', '2016-03-30 13:04:07', 329);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (409, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: mlawson@kelsan.biz
:user_id: 25
', 'f', '2016-03-30 13:05:02', '2016-03-30 13:05:02', 329);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (410, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: jjohnston@kelsan.biz
:user_id: 26
', 'f', '2016-03-30 13:06:58', '2016-03-30 13:06:58', 329);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (411, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: gwright@kelsan.biz
:user_id: 27
', 'f', '2016-03-30 13:10:58', '2016-03-30 13:10:58', 329);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (412, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: ccarr@kelsan.biz
:user_id: 28
', 'f', '2016-03-30 13:12:00', '2016-03-30 13:12:00', 329);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (413, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: clambright@kelsan.biz
:user_id: 29
', 'f', '2016-03-30 13:18:16', '2016-03-30 13:18:16', 329);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (414, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: jclark@kelsan.biz
:user_id: 30
', 'f', '2016-03-30 13:19:07', '2016-03-30 13:19:07', 329);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (417, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: info
:by_id: 12
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Help choose the next desk toy
:ticket_id: 26
', 'f', '2016-03-30 13:32:30', '2016-03-30 13:32:30', 332);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (418, 'ticket_updated', '--- 
:assigned_to: Lee T.
:by: Hemalatha G.
:by_id: 7
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - "2016-03-10"
  - "2016-03-30"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Test ticket
:ticket_id: 3
', 'f', '2016-03-30 19:11:13', '2016-03-30 19:11:13', 333);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (420, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Hemalatha G.
:by_id: 7
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-03-30"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Help choose the next desk toy
:ticket_id: 26
', 'f', '2016-03-30 19:13:51', '2016-03-30 19:13:51', 335);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (424, 'ticket_updated', '--- 
:assigned_to: Lee T.
:by: Hemalatha G.
:by_id: 7
:changes: 
  first_sub_cat: 
  - 
  - Research
  status_updated_at: 
  - "2016-03-10"
  - "2016-03-30"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: lthompson@kelsan.biz
:summary: Email Loop Filtering Test
:ticket_id: 4
', 'f', '2016-03-30 19:23:29', '2016-03-30 19:23:29', 339);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (427, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Hemalatha G.
:by_id: 7
:comment_id: 82
:comment_name: "Ticket #5"
:ticket_id: 5
:ticket_summary: Test Ticket 1
', 'f', '2016-03-30 19:25:27', '2016-03-30 19:25:27', 342);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (428, 'ticket_closed', '--- 
:assigned_to: Hemalatha G.
:by: Hemalatha G.
:by_id: 7
:device_ids: 
- 26
:due_at: 2016-03-24 17:00:00 -04:00
:email: hemalatha.gopisetty@ballistix.com
:past_due: false
:priority: Med
:related_to: Evernote
:submitter_display_name: hemalatha.gopisetty@ballistix.com
:summary: Test Ticket 1
:ticket_id: 5
', 'f', '2016-03-30 19:25:27', '2016-03-30 19:25:27', 343);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (429, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Hemalatha G.
:by_id: 7
:comment_id: 82
:comment_name: "Ticket #5"
:ticket_id: 5
:ticket_summary: Test Ticket 1
', 'f', '2016-03-30 19:25:27', '2016-03-30 19:25:27', 344);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (430, 'ticket_updated', '--- 
:assigned_to: Hemalatha G.
:by: Hemalatha G.
:by_id: 7
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-22"
  - "2016-03-30"
:device_ids: 
- 26
:due_at: 2016-03-24 17:00:00 -04:00
:past_due: false
:priority: Med
:related_to: Evernote
:submitter_display_name: hemalatha.gopisetty@ballistix.com
:summary: Test Ticket 1
:ticket_id: 5
', 'f', '2016-03-30 19:25:27', '2016-03-30 19:25:27', 345);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (431, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Hemalatha G.
:by_id: 7
:changes: 
  first_sub_cat: 
  - 
  - Reporting-Accounting
  status_updated_at: 
  - "2016-03-21"
  - "2016-03-30"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Testing
:ticket_id: 6
', 'f', '2016-03-30 19:25:45', '2016-03-30 19:25:45', 345);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (432, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 83
:comment_name: "Ticket #26"
:ticket_id: 26
:ticket_summary: Help choose the next desk toy
', 'f', '2016-03-31 10:01:14', '2016-03-31 10:01:14', 346);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (433, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Help choose the next desk toy
:ticket_id: 26
:to: Monty K.
:to_id: 5
', 'f', '2016-03-31 10:01:14', '2016-03-31 10:01:14', 347);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (434, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 83
:comment_name: "Ticket #26"
:ticket_id: 26
:ticket_summary: Help choose the next desk toy
', 'f', '2016-03-31 10:01:14', '2016-03-31 10:01:14', 348);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (435, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-03-30"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Help choose the next desk toy
:ticket_id: 26
', 'f', '2016-03-31 10:01:14', '2016-03-31 10:01:14', 349);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (436, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 84
:comment_name: "Ticket #26"
:ticket_id: 26
:ticket_summary: Help choose the next desk toy
', 'f', '2016-03-31 10:01:16', '2016-03-31 10:01:16', 350);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (437, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Help choose the next desk toy
:ticket_id: 26
', 'f', '2016-03-31 10:01:16', '2016-03-31 10:01:16', 351);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (438, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 84
:comment_name: "Ticket #26"
:ticket_id: 26
:ticket_summary: Help choose the next desk toy
', 'f', '2016-03-31 10:01:16', '2016-03-31 10:01:16', 352);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (439, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Help choose the next desk toy
:ticket_id: 26
', 'f', '2016-03-31 10:01:16', '2016-03-31 10:01:16', 353);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (440, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Justin C.
:by_id: 30
:comment_id: 85
:comment_name: "Ticket #27"
:ticket_id: 27
:ticket_summary: test order
', 'f', '2016-03-31 10:04:29', '2016-03-31 10:04:29', 354);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (441, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Justin C.
:by_id: 30
:comment_id: 85
:comment_name: "Ticket #27"
:ticket_id: 27
:ticket_summary: test order
', 'f', '2016-03-31 10:04:29', '2016-03-31 10:04:29', 354);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (442, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Justin C.
:by_id: 30
:comment_id: 85
:comment_name: "Ticket #27"
:ticket_id: 27
:ticket_summary: test order
', 'f', '2016-03-31 10:04:29', '2016-03-31 10:04:29', 354);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (443, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Justin C.
:by_id: 30
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jclark@kelsan.biz
:summary: test order
:ticket_id: 27
', 'f', '2016-03-31 10:04:29', '2016-03-31 10:04:29', 355);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (444, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 86
:comment_name: "Ticket #27"
:ticket_id: 27
:ticket_summary: test order
', 'f', '2016-03-31 10:05:30', '2016-03-31 10:05:30', 356);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (445, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jclark@kelsan.biz
:summary: test order
:ticket_id: 27
:to: Monty K.
:to_id: 5
', 'f', '2016-03-31 10:05:30', '2016-03-31 10:05:30', 357);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (446, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 86
:comment_name: "Ticket #27"
:ticket_id: 27
:ticket_summary: test order
', 'f', '2016-03-31 10:05:30', '2016-03-31 10:05:30', 358);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (447, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - 
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jclark@kelsan.biz
:summary: test order
:ticket_id: 27
', 'f', '2016-03-31 10:05:30', '2016-03-31 10:05:30', 359);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (448, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jclark@kelsan.biz
:summary: test order
:ticket_id: 27
', 'f', '2016-03-31 10:06:06', '2016-03-31 10:06:06', 359);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (449, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 87
:comment_name: "Ticket #27"
:ticket_id: 27
:ticket_summary: test order
', 'f', '2016-03-31 10:06:29', '2016-03-31 10:06:29', 360);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (450, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: jclark@kelsan.biz
:summary: test order
:ticket_id: 27
', 'f', '2016-03-31 10:06:29', '2016-03-31 10:06:29', 361);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (451, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 87
:comment_name: "Ticket #27"
:ticket_id: 27
:ticket_summary: test order
', 'f', '2016-03-31 10:06:29', '2016-03-31 10:06:29', 362);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (452, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: jclark@kelsan.biz
:summary: test order
:ticket_id: 27
', 'f', '2016-03-31 10:06:29', '2016-03-31 10:06:29', 363);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (453, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - "2016-03-24"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: PO80061749
:ticket_id: 13
', 'f', '2016-03-31 10:12:11', '2016-03-31 10:12:11', 363);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (454, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Justin C.
:by_id: 30
:comment_id: 88
:comment_name: "Ticket #28"
:ticket_id: 28
:ticket_summary: attachment
', 'f', '2016-03-31 10:12:28', '2016-03-31 10:12:28', 364);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (455, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Justin C.
:by_id: 30
:comment_id: 88
:comment_name: "Ticket #28"
:ticket_id: 28
:ticket_summary: attachment
', 'f', '2016-03-31 10:12:29', '2016-03-31 10:12:29', 364);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (456, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Justin C.
:by_id: 30
:comment_id: 88
:comment_name: "Ticket #28"
:ticket_id: 28
:ticket_summary: attachment
', 'f', '2016-03-31 10:12:29', '2016-03-31 10:12:29', 364);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (457, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Justin C.
:by_id: 30
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jclark@kelsan.biz
:summary: attachment
:ticket_id: 28
', 'f', '2016-03-31 10:12:29', '2016-03-31 10:12:29', 365);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (458, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jclark@kelsan.biz
:summary: attachment
:ticket_id: 28
', 'f', '2016-03-31 10:12:37', '2016-03-31 10:12:37', 366);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (459, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 90
:comment_name: "Ticket #28"
:ticket_id: 28
:ticket_summary: attachment
', 'f', '2016-03-31 10:12:44', '2016-03-31 10:12:44', 367);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (460, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jclark@kelsan.biz
:summary: attachment
:ticket_id: 28
:to: Monty K.
:to_id: 5
', 'f', '2016-03-31 10:12:44', '2016-03-31 10:12:44', 368);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (461, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 90
:comment_name: "Ticket #28"
:ticket_id: 28
:ticket_summary: attachment
', 'f', '2016-03-31 10:12:44', '2016-03-31 10:12:44', 369);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (462, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jclark@kelsan.biz
:summary: attachment
:ticket_id: 28
', 'f', '2016-03-31 10:12:44', '2016-03-31 10:12:44', 370);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (463, 'ticket_comment_added', '--- 
:body: Completed quote in SX.
:by: Monty K.
:by_id: 5
:comment_id: 91
:comment_name: "Ticket #28"
:ticket_id: 28
:ticket_summary: attachment
', 'f', '2016-03-31 10:13:17', '2016-03-31 10:13:17', 371);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (464, 'ticket_comment_added', '--- 
:body: Completed quote in SX.
:by: Monty K.
:by_id: 5
:comment_id: 91
:comment_name: "Ticket #28"
:ticket_id: 28
:ticket_summary: attachment
', 'f', '2016-03-31 10:13:17', '2016-03-31 10:13:17', 371);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (465, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 92
:comment_name: "Ticket #28"
:ticket_id: 28
:ticket_summary: attachment
', 'f', '2016-03-31 10:13:20', '2016-03-31 10:13:20', 371);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (466, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: jclark@kelsan.biz
:summary: attachment
:ticket_id: 28
', 'f', '2016-03-31 10:13:20', '2016-03-31 10:13:20', 372);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (467, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 92
:comment_name: "Ticket #28"
:ticket_id: 28
:ticket_summary: attachment
', 'f', '2016-03-31 10:13:20', '2016-03-31 10:13:20', 373);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (468, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: jclark@kelsan.biz
:summary: attachment
:ticket_id: 28
', 'f', '2016-03-31 10:13:20', '2016-03-31 10:13:20', 374);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (469, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 93
:comment_name: "Ticket #29"
:ticket_id: 29
:ticket_summary: Test
', 'f', '2016-03-31 10:24:29', '2016-03-31 10:24:29', 375);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (470, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 93
:comment_name: "Ticket #29"
:ticket_id: 29
:ticket_summary: Test
', 'f', '2016-03-31 10:24:29', '2016-03-31 10:24:29', 375);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (471, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 93
:comment_name: "Ticket #29"
:ticket_id: 29
:ticket_summary: Test
', 'f', '2016-03-31 10:24:29', '2016-03-31 10:24:29', 375);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (472, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 29
', 'f', '2016-03-31 10:24:29', '2016-03-31 10:24:29', 376);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (473, 'user_created', '--- 
:source: :user
:user_email: montykilburn@gmail.com
:user_id: 31
', 'f', '2016-03-31 10:27:29', '2016-03-31 10:27:29', 377);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (474, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: montykilburn
:by_id: 31
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: montykilburn@gmail.com
:summary: test
:ticket_id: 30
', 'f', '2016-03-31 10:27:29', '2016-03-31 10:27:29', 378);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (475, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: montykilburn@gmail.com
:summary: test
:ticket_id: 30
', 'f', '2016-03-31 10:28:07', '2016-03-31 10:28:07', 379);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (476, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 94
:comment_name: "Ticket #30"
:ticket_id: 30
:ticket_summary: test
', 'f', '2016-03-31 11:01:00', '2016-03-31 11:01:00', 380);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (477, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: montykilburn@gmail.com
:summary: test
:ticket_id: 30
:to: Monty K.
:to_id: 5
', 'f', '2016-03-31 11:01:00', '2016-03-31 11:01:00', 381);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (478, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 94
:comment_name: "Ticket #30"
:ticket_id: 30
:ticket_summary: test
', 'f', '2016-03-31 11:01:00', '2016-03-31 11:01:00', 382);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (479, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: montykilburn@gmail.com
:summary: test
:ticket_id: 30
', 'f', '2016-03-31 11:01:00', '2016-03-31 11:01:00', 383);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (480, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 95
:comment_name: "Ticket #30"
:ticket_id: 30
:ticket_summary: test
', 'f', '2016-03-31 11:01:03', '2016-03-31 11:01:03', 384);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (481, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: montykilburn@gmail.com
:summary: test
:ticket_id: 30
', 'f', '2016-03-31 11:01:03', '2016-03-31 11:01:03', 385);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (482, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 95
:comment_name: "Ticket #30"
:ticket_id: 30
:ticket_summary: test
', 'f', '2016-03-31 11:01:03', '2016-03-31 11:01:03', 386);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (483, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: montykilburn@gmail.com
:summary: test
:ticket_id: 30
', 'f', '2016-03-31 11:01:03', '2016-03-31 11:01:03', 387);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (484, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 96
:comment_name: "Ticket #29"
:ticket_id: 29
:ticket_summary: Test
', 'f', '2016-03-31 11:01:04', '2016-03-31 11:01:04', 388);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (485, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 29
:to: Monty K.
:to_id: 5
', 'f', '2016-03-31 11:01:04', '2016-03-31 11:01:04', 389);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (486, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 96
:comment_name: "Ticket #29"
:ticket_id: 29
:ticket_summary: Test
', 'f', '2016-03-31 11:01:04', '2016-03-31 11:01:04', 390);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (487, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 29
', 'f', '2016-03-31 11:01:05', '2016-03-31 11:01:05', 391);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (488, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 29
', 'f', '2016-03-31 11:01:05', '2016-03-31 11:01:05', 391);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (489, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 97
:comment_name: "Ticket #29"
:ticket_id: 29
:ticket_summary: Test
', 'f', '2016-03-31 11:01:06', '2016-03-31 11:01:06', 392);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (490, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 29
', 'f', '2016-03-31 11:01:06', '2016-03-31 11:01:06', 393);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (491, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 97
:comment_name: "Ticket #29"
:ticket_id: 29
:ticket_summary: Test
', 'f', '2016-03-31 11:01:06', '2016-03-31 11:01:06', 394);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (492, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 29
', 'f', '2016-03-31 11:01:06', '2016-03-31 11:01:06', 395);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (493, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 98
:comment_name: "Ticket #31"
:ticket_id: 31
:ticket_summary: Test
', 'f', '2016-03-31 12:04:29', '2016-03-31 12:04:29', 396);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (494, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 98
:comment_name: "Ticket #31"
:ticket_id: 31
:ticket_summary: Test
', 'f', '2016-03-31 12:04:29', '2016-03-31 12:04:29', 396);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (495, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 98
:comment_name: "Ticket #31"
:ticket_id: 31
:ticket_summary: Test
', 'f', '2016-03-31 12:04:29', '2016-03-31 12:04:29', 396);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (496, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 31
', 'f', '2016-03-31 12:04:29', '2016-03-31 12:04:29', 397);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (497, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 31
', 'f', '2016-03-31 12:04:41', '2016-03-31 12:04:41', 398);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (498, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 99
:comment_name: "Ticket #31"
:ticket_id: 31
:ticket_summary: Test
', 'f', '2016-03-31 12:05:01', '2016-03-31 12:05:01', 399);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (499, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 31
:to: Monty K.
:to_id: 5
', 'f', '2016-03-31 12:05:01', '2016-03-31 12:05:01', 400);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (500, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 99
:comment_name: "Ticket #31"
:ticket_id: 31
:ticket_summary: Test
', 'f', '2016-03-31 12:05:01', '2016-03-31 12:05:01', 401);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (501, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 31
', 'f', '2016-03-31 12:05:01', '2016-03-31 12:05:01', 402);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (502, 'ticket_comment_added', '--- 
:body: "Ticket closed: Entered Order #1234455"
:by: Monty K.
:by_id: 5
:comment_id: 100
:comment_name: "Ticket #31"
:ticket_id: 31
:ticket_summary: Test
', 'f', '2016-03-31 12:05:18', '2016-03-31 12:05:18', 403);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (503, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 31
', 'f', '2016-03-31 12:05:18', '2016-03-31 12:05:18', 404);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (504, 'ticket_comment_added', '--- 
:body: "Ticket closed: Entered Order #1234455"
:by: Monty K.
:by_id: 5
:comment_id: 100
:comment_name: "Ticket #31"
:ticket_id: 31
:ticket_summary: Test
', 'f', '2016-03-31 12:05:18', '2016-03-31 12:05:18', 405);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (505, 'ticket_comment_added', '--- 
:body: Ticket re-opened.
:by: Monty K.
:by_id: 5
:comment_id: 101
:comment_name: "Ticket #31"
:ticket_id: 31
:ticket_summary: Test
', 'f', '2016-03-31 12:07:48', '2016-03-31 12:07:48', 405);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (506, 'ticket_reopened', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 31
', 'f', '2016-03-31 12:07:49', '2016-03-31 12:07:49', 406);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (507, 'ticket_comment_added', '--- 
:body: Ticket re-opened.
:by: Monty K.
:by_id: 5
:comment_id: 101
:comment_name: "Ticket #31"
:ticket_id: 31
:ticket_summary: Test
', 'f', '2016-03-31 12:07:49', '2016-03-31 12:07:49', 407);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (508, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - closed
  - open
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 31
', 'f', '2016-03-31 12:07:49', '2016-03-31 12:07:49', 408);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (509, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 102
:comment_name: "Ticket #31"
:ticket_id: 31
:ticket_summary: Test
', 'f', '2016-03-31 12:07:50', '2016-03-31 12:07:50', 409);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (510, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 31
', 'f', '2016-03-31 12:07:50', '2016-03-31 12:07:50', 410);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (511, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 102
:comment_name: "Ticket #31"
:ticket_id: 31
:ticket_summary: Test
', 'f', '2016-03-31 12:07:50', '2016-03-31 12:07:50', 411);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (512, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 31
', 'f', '2016-03-31 12:07:50', '2016-03-31 12:07:50', 412);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (513, 'user_updated', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:updated: 
  role: admin
:user_email: redrosolano@kelsan.biz
:user_id: 20
', 'f', '2016-03-31 13:34:46', '2016-03-31 13:34:46', 413);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (514, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: klusk@kelsan.biz
:user_id: 32
', 'f', '2016-03-31 13:35:21', '2016-03-31 13:35:21', 414);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (515, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 32
', 'f', '2016-03-31 13:50:48', '2016-03-31 13:50:48', 415);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (516, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 103
:comment_name: "Ticket #32"
:ticket_id: 32
:ticket_summary: test
', 'f', '2016-03-31 13:55:28', '2016-03-31 13:55:28', 416);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (517, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 32
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-03-31 13:55:28', '2016-03-31 13:55:28', 417);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (518, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 103
:comment_name: "Ticket #32"
:ticket_id: 32
:ticket_summary: test
', 'f', '2016-03-31 13:55:28', '2016-03-31 13:55:28', 418);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (519, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - 
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 32
', 'f', '2016-03-31 13:55:28', '2016-03-31 13:55:28', 419);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (520, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 104
:comment_name: "Ticket #32"
:ticket_id: 32
:ticket_summary: test
', 'f', '2016-03-31 13:55:31', '2016-03-31 13:55:31', 420);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (521, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 32
', 'f', '2016-03-31 13:55:31', '2016-03-31 13:55:31', 421);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (522, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 104
:comment_name: "Ticket #32"
:ticket_id: 32
:ticket_summary: test
', 'f', '2016-03-31 13:55:31', '2016-03-31 13:55:31', 422);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (523, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 32
', 'f', '2016-03-31 13:55:31', '2016-03-31 13:55:31', 423);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (524, 'ticket_comment_added', '--- 
:body: Ticket re-opened.
:by: Elizabeth H.
:by_id: 9
:comment_id: 105
:comment_name: "Ticket #32"
:ticket_id: 32
:ticket_summary: test
', 'f', '2016-03-31 13:55:36', '2016-03-31 13:55:36', 424);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (525, 'ticket_reopened', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 32
', 'f', '2016-03-31 13:55:36', '2016-03-31 13:55:36', 425);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (526, 'ticket_comment_added', '--- 
:body: Ticket re-opened.
:by: Elizabeth H.
:by_id: 9
:comment_id: 105
:comment_name: "Ticket #32"
:ticket_id: 32
:ticket_summary: test
', 'f', '2016-03-31 13:55:36', '2016-03-31 13:55:36', 426);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (527, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status: 
  - closed
  - open
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 32
', 'f', '2016-03-31 13:55:36', '2016-03-31 13:55:36', 427);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (528, 'ticket_comment_added', '--- 
:body: blah
:by: Elizabeth H.
:by_id: 9
:comment_id: 106
:comment_name: "Ticket #32"
:ticket_id: 32
:ticket_summary: test
', 'f', '2016-03-31 13:55:54', '2016-03-31 13:55:54', 428);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (529, 'ticket_comment_added', '--- 
:body: blah
:by: Elizabeth H.
:by_id: 9
:comment_id: 106
:comment_name: "Ticket #32"
:ticket_id: 32
:ticket_summary: test
', 'f', '2016-03-31 13:55:54', '2016-03-31 13:55:54', 428);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (530, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 107
:comment_name: "Ticket #32"
:ticket_id: 32
:ticket_summary: test
', 'f', '2016-03-31 13:55:56', '2016-03-31 13:55:56', 428);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (531, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 32
', 'f', '2016-03-31 13:55:56', '2016-03-31 13:55:56', 429);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (532, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 107
:comment_name: "Ticket #32"
:ticket_id: 32
:ticket_summary: test
', 'f', '2016-03-31 13:55:56', '2016-03-31 13:55:56', 430);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (533, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 32
', 'f', '2016-03-31 13:55:56', '2016-03-31 13:55:56', 431);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (534, 'user_updated', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:updated: 
  role: end_user
:user_email: redrosolano@kelsan.biz
:user_id: 20
', 'f', '2016-03-31 13:57:50', '2016-03-31 13:57:50', 432);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (535, 'user_updated', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:updated: 
  role: admin
:user_email: redrosolano@kelsan.biz
:user_id: 20
', 'f', '2016-03-31 13:58:30', '2016-03-31 13:58:30', 432);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (536, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 108
:comment_name: "Ticket #33"
:ticket_id: 33
:ticket_summary: Packaging item
', 'f', '2016-03-31 13:59:29', '2016-03-31 13:59:29', 433);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (537, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 108
:comment_name: "Ticket #33"
:ticket_id: 33
:ticket_summary: Packaging item
', 'f', '2016-03-31 13:59:29', '2016-03-31 13:59:29', 433);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (538, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 108
:comment_name: "Ticket #33"
:ticket_id: 33
:ticket_summary: Packaging item
', 'f', '2016-03-31 13:59:29', '2016-03-31 13:59:29', 433);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (539, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Packaging item
:ticket_id: 33
', 'f', '2016-03-31 13:59:29', '2016-03-31 13:59:29', 434);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (540, 'ticket_comment_added', '--- 
:body: Assigned to Jennifer Hughes.
:by: Monty K.
:by_id: 5
:comment_id: 109
:comment_name: "Ticket #33"
:ticket_id: 33
:ticket_summary: Packaging item
', 'f', '2016-03-31 13:59:54', '2016-03-31 13:59:54', 435);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (541, 'ticket_reassigned', '--- 
:assigned_to: Jennifer H.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Packaging item
:ticket_id: 33
:to: Jennifer H.
:to_id: 24
', 'f', '2016-03-31 13:59:54', '2016-03-31 13:59:54', 436);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (542, 'ticket_comment_added', '--- 
:body: Assigned to Jennifer Hughes.
:by: Monty K.
:by_id: 5
:comment_id: 109
:comment_name: "Ticket #33"
:ticket_id: 33
:ticket_summary: Packaging item
', 'f', '2016-03-31 13:59:54', '2016-03-31 13:59:54', 437);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (543, 'ticket_updated', '--- 
:assigned_to: Jennifer H.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - 
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Packaging item
:ticket_id: 33
', 'f', '2016-03-31 13:59:55', '2016-03-31 13:59:55', 438);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (544, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 110
:comment_name: "Ticket #33"
:ticket_id: 33
:ticket_summary: Packaging item
', 'f', '2016-03-31 14:01:19', '2016-03-31 14:01:19', 439);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (545, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Packaging item
:ticket_id: 33
:to: Monty K.
:to_id: 5
', 'f', '2016-03-31 14:01:19', '2016-03-31 14:01:19', 440);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (546, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 110
:comment_name: "Ticket #33"
:ticket_id: 33
:ticket_summary: Packaging item
', 'f', '2016-03-31 14:01:19', '2016-03-31 14:01:19', 441);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (547, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Packaging item
:ticket_id: 33
', 'f', '2016-03-31 14:01:19', '2016-03-31 14:01:19', 442);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (548, 'ticket_comment_added', '--- 
:body: Keith said we don''t sell this.
:by: Monty K.
:by_id: 5
:comment_id: 111
:comment_name: "Ticket #33"
:ticket_id: 33
:ticket_summary: Packaging item
', 'f', '2016-03-31 14:01:35', '2016-03-31 14:01:35', 443);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (549, 'ticket_comment_added', '--- 
:body: Keith said we don''t sell this.
:by: Monty K.
:by_id: 5
:comment_id: 111
:comment_name: "Ticket #33"
:ticket_id: 33
:ticket_summary: Packaging item
', 'f', '2016-03-31 14:01:35', '2016-03-31 14:01:35', 443);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (550, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 112
:comment_name: "Ticket #33"
:ticket_id: 33
:ticket_summary: Packaging item
', 'f', '2016-03-31 14:01:37', '2016-03-31 14:01:37', 443);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (551, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Packaging item
:ticket_id: 33
', 'f', '2016-03-31 14:01:37', '2016-03-31 14:01:37', 444);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (552, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 112
:comment_name: "Ticket #33"
:ticket_id: 33
:ticket_summary: Packaging item
', 'f', '2016-03-31 14:01:37', '2016-03-31 14:01:37', 445);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (553, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Packaging item
:ticket_id: 33
', 'f', '2016-03-31 14:01:38', '2016-03-31 14:01:38', 446);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (554, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - "2016-03-31"
  - "2016-03-31"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 32
', 'f', '2016-03-31 14:01:45', '2016-03-31 14:01:45', 446);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (555, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: bcraig@kelsan.biz
:user_id: 33
', 'f', '2016-03-31 16:57:19', '2016-03-31 16:57:19', 447);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (556, 'report_schedule_instance_generated', '--- 
:report_name: "Cloud Services: Services Recently Accessed"
:reportschedule_id: 2
:reportschedule_name: "Report schedule #2"
', 'f', '2016-04-01 08:00:00', '2016-04-01 08:00:00', 448);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (557, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: info
:by_id: 12
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: The latest thin client technology at a low price.
:ticket_id: 34
', 'f', '2016-04-01 15:56:30', '2016-04-01 15:56:30', 449);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (558, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-04"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: The latest thin client technology at a low price.
:ticket_id: 34
', 'f', '2016-04-04 09:34:39', '2016-04-04 09:34:39', 450);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (559, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 113
:comment_name: "Ticket #34"
:ticket_id: 34
:ticket_summary: The latest thin client technology at a low price.
', 'f', '2016-04-04 09:34:47', '2016-04-04 09:34:47', 451);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (560, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: The latest thin client technology at a low price.
:ticket_id: 34
:to: Monty K.
:to_id: 5
', 'f', '2016-04-04 09:34:48', '2016-04-04 09:34:48', 452);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (561, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 113
:comment_name: "Ticket #34"
:ticket_id: 34
:ticket_summary: The latest thin client technology at a low price.
', 'f', '2016-04-04 09:34:48', '2016-04-04 09:34:48', 453);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (562, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-04-04"
  - "2016-04-04"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: The latest thin client technology at a low price.
:ticket_id: 34
', 'f', '2016-04-04 09:34:48', '2016-04-04 09:34:48', 454);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (563, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 114
:comment_name: "Ticket #34"
:ticket_id: 34
:ticket_summary: The latest thin client technology at a low price.
', 'f', '2016-04-04 09:34:50', '2016-04-04 09:34:50', 455);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (564, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: The latest thin client technology at a low price.
:ticket_id: 34
', 'f', '2016-04-04 09:34:50', '2016-04-04 09:34:50', 456);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (565, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 114
:comment_name: "Ticket #34"
:ticket_id: 34
:ticket_summary: The latest thin client technology at a low price.
', 'f', '2016-04-04 09:34:50', '2016-04-04 09:34:50', 457);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (566, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-04"
  - "2016-04-04"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: The latest thin client technology at a low price.
:ticket_id: 34
', 'f', '2016-04-04 09:34:50', '2016-04-04 09:34:50', 458);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (567, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 115
:comment_name: "Ticket #35"
:ticket_id: 35
:ticket_summary: The Kelsan Way
', 'f', '2016-04-04 09:36:29', '2016-04-04 09:36:29', 459);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (568, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 115
:comment_name: "Ticket #35"
:ticket_id: 35
:ticket_summary: The Kelsan Way
', 'f', '2016-04-04 09:36:29', '2016-04-04 09:36:29', 459);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (569, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 115
:comment_name: "Ticket #35"
:ticket_id: 35
:ticket_summary: The Kelsan Way
', 'f', '2016-04-04 09:36:29', '2016-04-04 09:36:29', 459);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (570, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: The Kelsan Way
:ticket_id: 35
', 'f', '2016-04-04 09:36:29', '2016-04-04 09:36:29', 460);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (571, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-04"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: The Kelsan Way
:ticket_id: 35
', 'f', '2016-04-04 10:19:18', '2016-04-04 10:19:18', 461);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (572, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - Unspecified
  - Pricing
  first_sub_cat: 
  - Unspecified
  - Pricing
  second_sub_cat: 
  - 
  - Other
  status_updated_at: 
  - "2016-04-04"
  - "2016-04-04"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: The Kelsan Way
:ticket_id: 35
', 'f', '2016-04-04 10:28:11', '2016-04-04 10:28:11', 461);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (573, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 116
:comment_name: "Ticket #35"
:ticket_id: 35
:ticket_summary: The Kelsan Way
', 'f', '2016-04-04 10:28:23', '2016-04-04 10:28:23', 462);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (574, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: The Kelsan Way
:ticket_id: 35
:to: Monty K.
:to_id: 5
', 'f', '2016-04-04 10:28:23', '2016-04-04 10:28:23', 463);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (575, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 116
:comment_name: "Ticket #35"
:ticket_id: 35
:ticket_summary: The Kelsan Way
', 'f', '2016-04-04 10:28:23', '2016-04-04 10:28:23', 464);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (576, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-04-04"
  - "2016-04-04"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: The Kelsan Way
:ticket_id: 35
', 'f', '2016-04-04 10:28:23', '2016-04-04 10:28:23', 465);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (577, 'ticket_comment_added', '--- 
:body: "Ticket closed: This is now closed."
:by: Monty K.
:by_id: 5
:comment_id: 117
:comment_name: "Ticket #35"
:ticket_id: 35
:ticket_summary: The Kelsan Way
', 'f', '2016-04-04 10:28:39', '2016-04-04 10:28:39', 466);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (578, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: The Kelsan Way
:ticket_id: 35
', 'f', '2016-04-04 10:28:39', '2016-04-04 10:28:39', 467);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (579, 'ticket_comment_added', '--- 
:body: "Ticket closed: This is now closed."
:by: Monty K.
:by_id: 5
:comment_id: 117
:comment_name: "Ticket #35"
:ticket_id: 35
:ticket_summary: The Kelsan Way
', 'f', '2016-04-04 10:28:39', '2016-04-04 10:28:39', 468);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (580, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Testing Subtickets
:ticket_id: 36
', 'f', '2016-04-04 11:52:16', '2016-04-04 11:52:16', 469);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (581, 'ticket_comment_added', '--- 
:body: Assigned to Scott Whitson.
:by: Scott W.
:by_id: 4
:comment_id: 118
:comment_name: "Ticket #36"
:ticket_id: 36
:ticket_summary: Testing Subtickets
', 'f', '2016-04-04 11:52:20', '2016-04-04 11:52:20', 470);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (582, 'ticket_reassigned', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Testing Subtickets
:ticket_id: 36
:to: Scott W.
:to_id: 4
', 'f', '2016-04-04 11:52:20', '2016-04-04 11:52:20', 471);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (583, 'ticket_comment_added', '--- 
:body: Assigned to Scott Whitson.
:by: Scott W.
:by_id: 4
:comment_id: 118
:comment_name: "Ticket #36"
:ticket_id: 36
:ticket_summary: Testing Subtickets
', 'f', '2016-04-04 11:52:20', '2016-04-04 11:52:20', 472);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (584, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  status_updated_at: 
  - 
  - "2016-04-04"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Testing Subtickets
:ticket_id: 36
', 'f', '2016-04-04 11:52:20', '2016-04-04 11:52:20', 473);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (585, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Scott W.
:by_id: 4
:comment_id: 119
:comment_name: "Ticket #37"
:ticket_id: 37
:ticket_summary: Please confirm subticket
', 'f', '2016-04-04 11:53:58', '2016-04-04 11:53:58', 474);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (586, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Please confirm subticket
:ticket_id: 37
:to: Monty K.
:to_id: 5
', 'f', '2016-04-04 11:53:58', '2016-04-04 11:53:58', 475);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (587, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Scott W.
:by_id: 4
:comment_id: 119
:comment_name: "Ticket #37"
:ticket_id: 37
:ticket_summary: Please confirm subticket
', 'f', '2016-04-04 11:53:58', '2016-04-04 11:53:58', 476);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (588, 'ticket_opened', '--- 
:assigned_to: Monty K.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Please confirm subticket
:ticket_id: 37
', 'f', '2016-04-04 11:53:58', '2016-04-04 11:53:58', 477);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (589, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #37: Please confirm subticket) added"
:by: Scott W.
:by_id: 4
:comment_id: 120
:comment_name: "Ticket #36"
:ticket_id: 36
:ticket_summary: Testing Subtickets
', 'f', '2016-04-04 11:53:58', '2016-04-04 11:53:58', 478);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (590, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #37: Please confirm subticket) added"
:by: Scott W.
:by_id: 4
:comment_id: 120
:comment_name: "Ticket #36"
:ticket_id: 36
:ticket_summary: Testing Subtickets
', 'f', '2016-04-04 11:53:58', '2016-04-04 11:53:58', 478);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (591, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 121
:comment_name: "Ticket #38"
:ticket_id: 38
:ticket_summary: Hi Justin
', 'f', '2016-04-04 11:54:29', '2016-04-04 11:54:29', 478);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (592, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 121
:comment_name: "Ticket #38"
:ticket_id: 38
:ticket_summary: Hi Justin
', 'f', '2016-04-04 11:54:29', '2016-04-04 11:54:29', 478);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (593, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 121
:comment_name: "Ticket #38"
:ticket_id: 38
:ticket_summary: Hi Justin
', 'f', '2016-04-04 11:54:29', '2016-04-04 11:54:29', 478);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (594, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 121
:comment_name: "Ticket #38"
:ticket_id: 38
:ticket_summary: Hi Justin
', 'f', '2016-04-04 11:54:29', '2016-04-04 11:54:29', 478);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (595, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Hi Justin
:ticket_id: 38
', 'f', '2016-04-04 11:54:29', '2016-04-04 11:54:29', 479);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (596, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 122
:comment_name: "Ticket #38"
:ticket_id: 38
:ticket_summary: Hi Justin
', 'f', '2016-04-04 11:54:47', '2016-04-04 11:54:47', 480);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (597, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Hi Justin
:ticket_id: 38
:to: Monty K.
:to_id: 5
', 'f', '2016-04-04 11:54:48', '2016-04-04 11:54:48', 481);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (598, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 122
:comment_name: "Ticket #38"
:ticket_id: 38
:ticket_summary: Hi Justin
', 'f', '2016-04-04 11:54:48', '2016-04-04 11:54:48', 482);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (599, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - 
  - "2016-04-04"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Hi Justin
:ticket_id: 38
', 'f', '2016-04-04 11:54:48', '2016-04-04 11:54:48', 483);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (600, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Customer Service
  first_sub_cat: 
  - 
  - Customer Service
  second_sub_cat: 
  - 
  - Quote
  status_updated_at: 
  - "2016-04-04"
  - "2016-04-04"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Hi Justin
:ticket_id: 38
', 'f', '2016-04-04 11:55:01', '2016-04-04 11:55:01', 483);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (601, 'ticket_comment_added', '--- 
:body: Thank you Justin for your order.
:by: Monty K.
:by_id: 5
:comment_id: 123
:comment_name: "Ticket #38"
:ticket_id: 38
:ticket_summary: Hi Justin
', 'f', '2016-04-04 11:55:29', '2016-04-04 11:55:29', 484);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (602, 'ticket_comment_added', '--- 
:body: Thank you Justin for your order.
:by: Monty K.
:by_id: 5
:comment_id: 123
:comment_name: "Ticket #38"
:ticket_id: 38
:ticket_summary: Hi Justin
', 'f', '2016-04-04 11:55:29', '2016-04-04 11:55:29', 484);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (603, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 124
:comment_name: "Ticket #38"
:ticket_id: 38
:ticket_summary: Hi Justin
', 'f', '2016-04-04 11:55:31', '2016-04-04 11:55:31', 484);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (604, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Hi Justin
:ticket_id: 38
', 'f', '2016-04-04 11:55:31', '2016-04-04 11:55:31', 485);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (605, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 124
:comment_name: "Ticket #38"
:ticket_id: 38
:ticket_summary: Hi Justin
', 'f', '2016-04-04 11:55:31', '2016-04-04 11:55:31', 486);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (606, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-04"
  - "2016-04-04"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Hi Justin
:ticket_id: 38
', 'f', '2016-04-04 11:55:31', '2016-04-04 11:55:31', 487);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (607, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #37: Please confirm subticket) closed"
:by: Monty K.
:by_id: 5
:comment_id: 125
:comment_name: "Ticket #36"
:ticket_id: 36
:ticket_summary: Testing Subtickets
', 'f', '2016-04-04 12:12:22', '2016-04-04 12:12:22', 488);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (608, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #37: Please confirm subticket) closed"
:by: Monty K.
:by_id: 5
:comment_id: 125
:comment_name: "Ticket #36"
:ticket_id: 36
:ticket_summary: Testing Subtickets
', 'f', '2016-04-04 12:12:22', '2016-04-04 12:12:22', 488);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (609, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 126
:comment_name: "Ticket #37"
:ticket_id: 37
:ticket_summary: Please confirm subticket
', 'f', '2016-04-04 12:12:22', '2016-04-04 12:12:22', 488);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (610, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Please confirm subticket
:ticket_id: 37
', 'f', '2016-04-04 12:12:23', '2016-04-04 12:12:23', 489);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (611, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 126
:comment_name: "Ticket #37"
:ticket_id: 37
:ticket_summary: Please confirm subticket
', 'f', '2016-04-04 12:12:23', '2016-04-04 12:12:23', 490);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (612, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - 
  - "2016-04-04"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Please confirm subticket
:ticket_id: 37
', 'f', '2016-04-04 12:12:23', '2016-04-04 12:12:23', 491);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (613, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Scott W.
:by_id: 4
:comment_id: 127
:comment_name: "Ticket #36"
:ticket_id: 36
:ticket_summary: Testing Subtickets
', 'f', '2016-04-04 12:13:44', '2016-04-04 12:13:44', 492);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (614, 'ticket_closed', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:email: swhitson@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Testing Subtickets
:ticket_id: 36
', 'f', '2016-04-04 12:13:44', '2016-04-04 12:13:44', 493);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (615, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Scott W.
:by_id: 4
:comment_id: 127
:comment_name: "Ticket #36"
:ticket_id: 36
:ticket_summary: Testing Subtickets
', 'f', '2016-04-04 12:13:44', '2016-04-04 12:13:44', 494);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (616, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  category: 
  - 
  - Unspecified
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-04"
  - "2016-04-04"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Testing Subtickets
:ticket_id: 36
', 'f', '2016-04-04 12:13:45', '2016-04-04 12:13:45', 495);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (617, 'user_updated', '--- 
:by: Scott W.
:by_id: 4
:source: :user
:updated: 
  role: end_user
:user_email: redrosolano@kelsan.biz
:user_id: 20
', 'f', '2016-04-04 13:50:04', '2016-04-04 13:50:04', 496);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (618, 'user_updated', '--- 
:by: Scott W.
:by_id: 4
:source: :user
:updated: 
  role: admin
:user_email: redrosolano@kelsan.biz
:user_id: 20
', 'f', '2016-04-04 13:51:05', '2016-04-04 13:51:05', 496);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (619, 'user_updated', '--- 
:by: Scott W.
:by_id: 4
:source: :user
:updated: 
  role: end_user
:user_email: jjohnston@kelsan.biz
:user_id: 26
', 'f', '2016-04-04 13:54:34', '2016-04-04 13:54:34', 496);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (620, 'user_updated', '--- 
:by: Scott W.
:by_id: 4
:source: :user
:updated: 
  role: helpdesk_admin
:user_email: jjohnston@kelsan.biz
:user_id: 26
', 'f', '2016-04-04 13:55:25', '2016-04-04 13:55:25', 496);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (621, 'user_updated', '--- 
:by: Scott W.
:by_id: 4
:source: :user
:updated: 
  role: end_user
:user_email: klusk@kelsan.biz
:user_id: 32
', 'f', '2016-04-04 16:16:24', '2016-04-04 16:16:24', 496);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (622, 'user_updated', '--- 
:by: Scott W.
:by_id: 4
:source: :user
:updated: 
  role: admin
:user_email: klusk@kelsan.biz
:user_id: 32
', 'f', '2016-04-04 16:16:39', '2016-04-04 16:16:39', 496);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (627, 'ticket_comment_added', '--- 
:body: Assigned to Reymund Edrosolano.
:by: Reymund E.
:by_id: 20
:comment_id: 128
:comment_name: "Ticket #39"
:ticket_id: 39
:ticket_summary: Template Preview / Draft
', 'f', '2016-04-05 10:03:37', '2016-04-05 10:03:37', 501);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (628, 'ticket_reassigned', '--- 
:assigned_to: Reymund E.
:by: Reymund E.
:by_id: 20
:device_ids: []

:due_at: 2016-04-05 17:00:00 -04:00
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: redrosolano@kelsan.biz
:summary: Template Preview / Draft
:ticket_id: 39
:to: Reymund E.
:to_id: 20
', 'f', '2016-04-05 10:03:37', '2016-04-05 10:03:37', 502);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (629, 'ticket_comment_added', '--- 
:body: Assigned to Reymund Edrosolano.
:by: Reymund E.
:by_id: 20
:comment_id: 128
:comment_name: "Ticket #39"
:ticket_id: 39
:ticket_summary: Template Preview / Draft
', 'f', '2016-04-05 10:03:37', '2016-04-05 10:03:37', 503);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (630, 'ticket_opened', '--- 
:assigned_to: Reymund E.
:by: Reymund E.
:by_id: 20
:device_ids: []

:due_at: 2016-04-05 17:00:00 -04:00
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: redrosolano@kelsan.biz
:summary: Template Preview / Draft
:ticket_id: 39
', 'f', '2016-04-05 10:03:37', '2016-04-05 10:03:37', 504);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (634, 'ticket_updated', '--- 
:assigned_to: Reymund E.
:by: Reymund E.
:by_id: 20
:changes: 
  category: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-05"
:device_ids: []

:due_at: 2016-04-05 17:00:00 -04:00
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: redrosolano@kelsan.biz
:summary: Template Preview / Draft
:ticket_id: 39
', 'f', '2016-04-05 10:04:00', '2016-04-05 10:04:00', 508);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (637, 'ticket_updated', '--- 
:assigned_to: Reymund E.
:by: Reymund E.
:by_id: 20
:changes: 
  status_updated_at: 
  - "2016-04-05"
  - "2016-04-05"
:device_ids: []

:due_at: 2016-04-05 17:00:00 -04:00
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: redrosolano@kelsan.biz
:summary: Template Preview / Draft
:ticket_id: 39
', 'f', '2016-04-05 10:06:50', '2016-04-05 10:06:50', 511);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (640, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Reymund E.
:by_id: 20
:comment_id: 129
:comment_name: "Ticket #39"
:ticket_id: 39
:ticket_summary: Template Preview / Draft
', 'f', '2016-04-05 11:13:41', '2016-04-05 11:13:41', 514);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (641, 'ticket_closed', '--- 
:assigned_to: Reymund E.
:by: Reymund E.
:by_id: 20
:device_ids: []

:due_at: 2016-04-05 17:00:00 -04:00
:email: redrosolano@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: redrosolano@kelsan.biz
:summary: Template Preview / Draft
:ticket_id: 39
', 'f', '2016-04-05 11:13:41', '2016-04-05 11:13:41', 515);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (642, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Reymund E.
:by_id: 20
:comment_id: 129
:comment_name: "Ticket #39"
:ticket_id: 39
:ticket_summary: Template Preview / Draft
', 'f', '2016-04-05 11:13:41', '2016-04-05 11:13:41', 516);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (643, 'ticket_updated', '--- 
:assigned_to: Reymund E.
:by: Reymund E.
:by_id: 20
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-05"
  - "2016-04-05"
:device_ids: []

:due_at: 2016-04-05 17:00:00 -04:00
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: redrosolano@kelsan.biz
:summary: Template Preview / Draft
:ticket_id: 39
', 'f', '2016-04-05 11:13:41', '2016-04-05 11:13:41', 517);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (644, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 130
:comment_name: "Ticket #40"
:ticket_id: 40
:ticket_summary: test
', 'f', '2016-04-05 13:57:13', '2016-04-05 13:57:13', 518);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (645, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 40
:to: Monty K.
:to_id: 5
', 'f', '2016-04-05 13:57:13', '2016-04-05 13:57:13', 519);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (646, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 130
:comment_name: "Ticket #40"
:ticket_id: 40
:ticket_summary: test
', 'f', '2016-04-05 13:57:14', '2016-04-05 13:57:14', 520);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (647, 'ticket_opened', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 40
', 'f', '2016-04-05 13:57:14', '2016-04-05 13:57:14', 521);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (648, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 131
:comment_name: "Ticket #40"
:ticket_id: 40
:ticket_summary: test
', 'f', '2016-04-05 14:01:01', '2016-04-05 14:01:01', 522);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (649, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 40
', 'f', '2016-04-05 14:01:01', '2016-04-05 14:01:01', 523);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (650, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 131
:comment_name: "Ticket #40"
:ticket_id: 40
:ticket_summary: test
', 'f', '2016-04-05 14:01:01', '2016-04-05 14:01:01', 524);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (651, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  status: 
  - open
  - closed
  status_updated_at: 
  - 
  - "2016-04-05"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 40
', 'f', '2016-04-05 14:01:01', '2016-04-05 14:01:01', 525);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (652, 'ticket_comment_added', '--- 
:body: |-
  Test
  
  Sent from my iPhone
  
  >
:by: montykilburn
:by_id: 31
:comment_id: 132
:comment_name: "Ticket #40"
:ticket_id: 40
:ticket_summary: test
', 'f', '2016-04-05 14:01:29', '2016-04-05 14:01:29', 526);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (653, 'ticket_comment_added', '--- 
:body: |-
  Test
  
  Sent from my iPhone
  
  >
:by: montykilburn
:by_id: 31
:comment_id: 132
:comment_name: "Ticket #40"
:ticket_id: 40
:ticket_summary: test
', 'f', '2016-04-05 14:01:30', '2016-04-05 14:01:30', 526);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (654, 'ticket_opened', '--- 
:assigned_to: Monty K.
:by: montykilburn
:by_id: 31
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 40
', 'f', '2016-04-05 14:01:30', '2016-04-05 14:01:30', 527);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (655, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Jade J.
:by_id: 26
:comment_id: 133
:comment_name: "Ticket #41"
:ticket_id: 41
:ticket_summary: Testing-Jade
', 'f', '2016-04-05 15:00:29', '2016-04-05 15:00:29', 528);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (656, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Jade J.
:by_id: 26
:comment_id: 133
:comment_name: "Ticket #41"
:ticket_id: 41
:ticket_summary: Testing-Jade
', 'f', '2016-04-05 15:00:29', '2016-04-05 15:00:29', 528);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (657, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Jade J.
:by_id: 26
:comment_id: 133
:comment_name: "Ticket #41"
:ticket_id: 41
:ticket_summary: Testing-Jade
', 'f', '2016-04-05 15:00:29', '2016-04-05 15:00:29', 528);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (658, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Jade J.
:by_id: 26
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jjohnston@kelsan.biz
:summary: Testing-Jade
:ticket_id: 41
', 'f', '2016-04-05 15:00:30', '2016-04-05 15:00:30', 529);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (659, 'ticket_comment_added', '--- 
:body: "Testing to see if it creates a new ticket or updates the current ticket.\n\n\
  From: Test CustServ HD\n\
  Sent: Tuesday, April 5, 2016 3:01 PM\n\
  To: Jade Johnston <jjohnston@kelsan.biz>\n\
  Subject: [Ticket #41] Testing-Jade - Spiceworks\n\n\
  Customer Service Help Desk\n\n |\n\n\
  Jade Johnston,\n\n\
  A new ticket has been added to the Kelsan Customer Service Help Desk system.\n\n\
  TICKET #41\n\n\
  Summary: Testing-Jade\n\n\
  Description:\n\n\
  Jad\xC3\xA9 Johnston, MBA\n\n\
  Director of Supply Chain & Logistics\n\n\
  5109 National Drive\n\n\
  Knoxville, TN 37914\n\n\
  Ph: 865-684-2560\n\n\
  Cell: 865-603-4420\n\n\
  www.kelsan.biz (http://www.kelsan.biz)\n\n |\n\n\
  Ticket History\n\n\
  _______________________________"
:by: Jade J.
:by_id: 26
:comment_id: 134
:comment_name: "Ticket #41"
:ticket_id: 41
:ticket_summary: Testing-Jade
', 'f', '2016-04-05 15:03:29', '2016-04-05 15:03:29', 530);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (660, 'ticket_comment_added', '--- 
:body: "Testing to see if it creates a new ticket or updates the current ticket.\n\n\
  From: Test CustServ HD\n\
  Sent: Tuesday, April 5, 2016 3:01 PM\n\
  To: Jade Johnston <jjohnston@kelsan.biz>\n\
  Subject: [Ticket #41] Testing-Jade - Spiceworks\n\n\
  Customer Service Help Desk\n\n |\n\n\
  Jade Johnston,\n\n\
  A new ticket has been added to the Kelsan Customer Service Help Desk system.\n\n\
  TICKET #41\n\n\
  Summary: Testing-Jade\n\n\
  Description:\n\n\
  Jad\xC3\xA9 Johnston, MBA\n\n\
  Director of Supply Chain & Logistics\n\n\
  5109 National Drive\n\n\
  Knoxville, TN 37914\n\n\
  Ph: 865-684-2560\n\n\
  Cell: 865-603-4420\n\n\
  www.kelsan.biz (http://www.kelsan.biz)\n\n |\n\n\
  Ticket History\n\n\
  _______________________________"
:by: Jade J.
:by_id: 26
:comment_id: 134
:comment_name: "Ticket #41"
:ticket_id: 41
:ticket_summary: Testing-Jade
', 'f', '2016-04-05 15:03:29', '2016-04-05 15:03:29', 530);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (661, 'ticket_reassigned', '--- 
:assigned_to: Jade J.
:by: Jade J.
:by_id: 26
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jjohnston@kelsan.biz
:summary: Testing-Jade
:ticket_id: 41
:to: Jade J.
:to_id: 26
', 'f', '2016-04-05 15:03:29', '2016-04-05 15:03:29', 531);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (662, 'ticket_comment_added', '--- 
:body: "Testing to see if it creates a new ticket or updates the current ticket.\n\n\
  From: Test CustServ HD\n\
  Sent: Tuesday, April 5, 2016 3:01 PM\n\
  To: Jade Johnston <jjohnston@kelsan.biz>\n\
  Subject: [Ticket #41] Testing-Jade - Spiceworks\n\n\
  Customer Service Help Desk\n\n |\n\n\
  Jade Johnston,\n\n\
  A new ticket has been added to the Kelsan Customer Service Help Desk system.\n\n\
  TICKET #41\n\n\
  Summary: Testing-Jade\n\n\
  Description:\n\n\
  Jad\xC3\xA9 Johnston, MBA\n\n\
  Director of Supply Chain & Logistics\n\n\
  5109 National Drive\n\n\
  Knoxville, TN 37914\n\n\
  Ph: 865-684-2560\n\n\
  Cell: 865-603-4420\n\n\
  www.kelsan.biz (http://www.kelsan.biz)\n\n |\n\n\
  Ticket History\n\n\
  _______________________________"
:by: Jade J.
:by_id: 26
:comment_id: 134
:comment_name: "Ticket #41"
:ticket_id: 41
:ticket_summary: Testing-Jade
', 'f', '2016-04-05 15:03:29', '2016-04-05 15:03:29', 532);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (663, 'ticket_opened', '--- 
:assigned_to: Jade J.
:by: Jade J.
:by_id: 26
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jjohnston@kelsan.biz
:summary: Testing-Jade
:ticket_id: 41
', 'f', '2016-04-05 15:03:29', '2016-04-05 15:03:29', 533);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (664, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Jade J.
:by_id: 26
:comment_id: 136
:comment_name: "Ticket #42"
:ticket_id: 42
:ticket_summary: Test 2 Jade
', 'f', '2016-04-05 15:06:29', '2016-04-05 15:06:29', 534);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (665, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Jade J.
:by_id: 26
:comment_id: 136
:comment_name: "Ticket #42"
:ticket_id: 42
:ticket_summary: Test 2 Jade
', 'f', '2016-04-05 15:06:29', '2016-04-05 15:06:29', 534);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (666, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Jade J.
:by_id: 26
:comment_id: 136
:comment_name: "Ticket #42"
:ticket_id: 42
:ticket_summary: Test 2 Jade
', 'f', '2016-04-05 15:06:30', '2016-04-05 15:06:30', 534);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (667, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Jade J.
:by_id: 26
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jjohnston@kelsan.biz
:summary: Test 2 Jade
:ticket_id: 42
', 'f', '2016-04-05 15:06:30', '2016-04-05 15:06:30', 535);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (668, 'ticket_comment_added', '--- 
:body: |-
  I want this ticket.
  
  Sent from my iPhone
:by: Monty K.
:by_id: 5
:comment_id: 137
:comment_name: "Ticket #42"
:ticket_id: 42
:ticket_summary: Test 2 Jade
', 'f', '2016-04-05 15:07:28', '2016-04-05 15:07:28', 536);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (669, 'ticket_comment_added', '--- 
:body: |-
  I want this ticket.
  
  Sent from my iPhone
:by: Monty K.
:by_id: 5
:comment_id: 137
:comment_name: "Ticket #42"
:ticket_id: 42
:ticket_summary: Test 2 Jade
', 'f', '2016-04-05 15:07:28', '2016-04-05 15:07:28', 536);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (670, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jjohnston@kelsan.biz
:summary: Test 2 Jade
:ticket_id: 42
:to: Monty K.
:to_id: 5
', 'f', '2016-04-05 15:07:28', '2016-04-05 15:07:28', 537);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (671, 'ticket_comment_added', '--- 
:body: |-
  I want this ticket.
  
  Sent from my iPhone
:by: Monty K.
:by_id: 5
:comment_id: 137
:comment_name: "Ticket #42"
:ticket_id: 42
:ticket_summary: Test 2 Jade
', 'f', '2016-04-05 15:07:28', '2016-04-05 15:07:28', 538);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (672, 'ticket_opened', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jjohnston@kelsan.biz
:summary: Test 2 Jade
:ticket_id: 42
', 'f', '2016-04-05 15:07:28', '2016-04-05 15:07:28', 539);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (673, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 139
:comment_name: "Ticket #42"
:ticket_id: 42
:ticket_summary: Test 2 Jade
', 'f', '2016-04-05 15:26:22', '2016-04-05 15:26:22', 540);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (674, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: jjohnston@kelsan.biz
:summary: Test 2 Jade
:ticket_id: 42
', 'f', '2016-04-05 15:26:22', '2016-04-05 15:26:22', 541);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (675, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 139
:comment_name: "Ticket #42"
:ticket_id: 42
:ticket_summary: Test 2 Jade
', 'f', '2016-04-05 15:26:22', '2016-04-05 15:26:22', 542);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (676, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - 
  - "2016-04-05"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: jjohnston@kelsan.biz
:summary: Test 2 Jade
:ticket_id: 42
', 'f', '2016-04-05 15:26:22', '2016-04-05 15:26:22', 543);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (677, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 43
', 'f', '2016-04-06 09:04:13', '2016-04-06 09:04:13', 544);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (678, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Order
:ticket_id: 44
', 'f', '2016-04-06 09:06:33', '2016-04-06 09:06:33', 544);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (679, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #44: Order) added"
:by: Monty K.
:by_id: 5
:comment_id: 140
:comment_name: "Ticket #43"
:ticket_id: 43
:ticket_summary: Test
', 'f', '2016-04-06 09:06:33', '2016-04-06 09:06:33', 545);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (680, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #44: Order) added"
:by: Monty K.
:by_id: 5
:comment_id: 140
:comment_name: "Ticket #43"
:ticket_id: 43
:ticket_summary: Test
', 'f', '2016-04-06 09:06:33', '2016-04-06 09:06:33', 545);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (681, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 141
:comment_name: "Ticket #43"
:ticket_id: 43
:ticket_summary: Test
', 'f', '2016-04-06 09:06:58', '2016-04-06 09:06:58', 545);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (682, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 43
:to: Monty K.
:to_id: 5
', 'f', '2016-04-06 09:06:58', '2016-04-06 09:06:58', 546);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (683, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 141
:comment_name: "Ticket #43"
:ticket_id: 43
:ticket_summary: Test
', 'f', '2016-04-06 09:06:58', '2016-04-06 09:06:58', 547);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (684, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - 
  - "2016-04-06"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 43
', 'f', '2016-04-06 09:06:58', '2016-04-06 09:06:58', 548);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (685, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: opshelp@kelsan.biz
:user_id: 34
', 'f', '2016-04-06 09:09:13', '2016-04-06 09:09:13', 549);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (686, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 142
:comment_name: "Ticket #44"
:ticket_id: 44
:ticket_summary: Order
', 'f', '2016-04-06 09:10:21', '2016-04-06 09:10:21', 550);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (687, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Order
:ticket_id: 44
:to: Monty K.
:to_id: 5
', 'f', '2016-04-06 09:10:21', '2016-04-06 09:10:21', 551);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (688, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 142
:comment_name: "Ticket #44"
:ticket_id: 44
:ticket_summary: Order
', 'f', '2016-04-06 09:10:21', '2016-04-06 09:10:21', 552);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (689, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-06"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Order
:ticket_id: 44
', 'f', '2016-04-06 09:10:21', '2016-04-06 09:10:21', 553);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (690, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: info
:by_id: 12
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Less is more with SanDisk flash storage technology
:ticket_id: 45
', 'f', '2016-04-06 13:04:29', '2016-04-06 13:04:29', 554);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (691, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 143
:comment_name: "Ticket #45"
:ticket_id: 45
:ticket_summary: Less is more with SanDisk flash storage technology
', 'f', '2016-04-06 13:16:23', '2016-04-06 13:16:23', 555);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (692, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Less is more with SanDisk flash storage technology
:ticket_id: 45
:to: Monty K.
:to_id: 5
', 'f', '2016-04-06 13:16:23', '2016-04-06 13:16:23', 556);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (693, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 143
:comment_name: "Ticket #45"
:ticket_id: 45
:ticket_summary: Less is more with SanDisk flash storage technology
', 'f', '2016-04-06 13:16:23', '2016-04-06 13:16:23', 557);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (694, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - 
  - "2016-04-06"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Less is more with SanDisk flash storage technology
:ticket_id: 45
', 'f', '2016-04-06 13:16:23', '2016-04-06 13:16:23', 558);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (695, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 144
:comment_name: "Ticket #45"
:ticket_id: 45
:ticket_summary: Less is more with SanDisk flash storage technology
', 'f', '2016-04-06 13:16:25', '2016-04-06 13:16:25', 559);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (696, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Less is more with SanDisk flash storage technology
:ticket_id: 45
', 'f', '2016-04-06 13:16:25', '2016-04-06 13:16:25', 560);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (697, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 144
:comment_name: "Ticket #45"
:ticket_id: 45
:ticket_summary: Less is more with SanDisk flash storage technology
', 'f', '2016-04-06 13:16:25', '2016-04-06 13:16:25', 561);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (698, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-06"
  - "2016-04-06"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: info@em.spiceworks.com
:summary: Less is more with SanDisk flash storage technology
:ticket_id: 45
', 'f', '2016-04-06 13:16:25', '2016-04-06 13:16:25', 562);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (699, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: kspeth@kelsan.biz
:user_id: 35
', 'f', '2016-04-06 13:23:46', '2016-04-06 13:23:46', 563);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (700, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #44: Order) closed"
:by: Monty K.
:by_id: 5
:comment_id: 145
:comment_name: "Ticket #43"
:ticket_id: 43
:ticket_summary: Test
', 'f', '2016-04-07 08:25:15', '2016-04-07 08:25:15', 564);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (701, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #44: Order) closed"
:by: Monty K.
:by_id: 5
:comment_id: 145
:comment_name: "Ticket #43"
:ticket_id: 43
:ticket_summary: Test
', 'f', '2016-04-07 08:25:15', '2016-04-07 08:25:15', 564);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (702, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 146
:comment_name: "Ticket #44"
:ticket_id: 44
:ticket_summary: Order
', 'f', '2016-04-07 08:25:15', '2016-04-07 08:25:15', 564);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (703, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Order
:ticket_id: 44
', 'f', '2016-04-07 08:25:15', '2016-04-07 08:25:15', 565);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (704, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 146
:comment_name: "Ticket #44"
:ticket_id: 44
:ticket_summary: Order
', 'f', '2016-04-07 08:25:15', '2016-04-07 08:25:15', 566);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (705, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-06"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Order
:ticket_id: 44
', 'f', '2016-04-07 08:25:15', '2016-04-07 08:25:15', 567);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (706, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 147
:comment_name: "Ticket #43"
:ticket_id: 43
:ticket_summary: Test
', 'f', '2016-04-07 08:25:20', '2016-04-07 08:25:20', 568);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (707, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 43
', 'f', '2016-04-07 08:25:20', '2016-04-07 08:25:20', 569);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (708, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 147
:comment_name: "Ticket #43"
:ticket_id: 43
:ticket_summary: Test
', 'f', '2016-04-07 08:25:20', '2016-04-07 08:25:20', 570);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (709, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-06"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test
:ticket_id: 43
', 'f', '2016-04-07 08:25:20', '2016-04-07 08:25:20', 571);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (710, 'ticket_updated', '--- 
:assigned_to: Jade J.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: jjohnston@kelsan.biz
:summary: Testing-Jade
:ticket_id: 41
', 'f', '2016-04-07 08:27:00', '2016-04-07 08:27:00', 571);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (711, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 148
:comment_name: "Ticket #46"
:ticket_id: 46
:ticket_summary: Test for Brad
', 'f', '2016-04-07 08:44:57', '2016-04-07 08:44:57', 572);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (712, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Brad
:ticket_id: 46
:to: Monty K.
:to_id: 5
', 'f', '2016-04-07 08:44:57', '2016-04-07 08:44:57', 573);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (713, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 148
:comment_name: "Ticket #46"
:ticket_id: 46
:ticket_summary: Test for Brad
', 'f', '2016-04-07 08:44:57', '2016-04-07 08:44:57', 574);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (714, 'ticket_opened', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Brad
:ticket_id: 46
', 'f', '2016-04-07 08:44:57', '2016-04-07 08:44:57', 575);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (715, 'ticket_comment_added', '--- 
:body: Assigned to Operations Help Desk.
:by: Monty K.
:by_id: 5
:comment_id: 149
:comment_name: "Ticket #47"
:ticket_id: 47
:ticket_summary: Test for Brad
', 'f', '2016-04-07 08:45:34', '2016-04-07 08:45:34', 576);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (716, 'ticket_reassigned', '--- 
:assigned_to: Operations H.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Brad
:ticket_id: 47
:to: Operations H.
:to_id: 34
', 'f', '2016-04-07 08:45:34', '2016-04-07 08:45:34', 577);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (717, 'ticket_comment_added', '--- 
:body: Assigned to Operations Help Desk.
:by: Monty K.
:by_id: 5
:comment_id: 149
:comment_name: "Ticket #47"
:ticket_id: 47
:ticket_summary: Test for Brad
', 'f', '2016-04-07 08:45:34', '2016-04-07 08:45:34', 578);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (718, 'ticket_opened', '--- 
:assigned_to: Operations H.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Brad
:ticket_id: 47
', 'f', '2016-04-07 08:45:34', '2016-04-07 08:45:34', 579);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (719, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #47: Test for Brad) added"
:by: Monty K.
:by_id: 5
:comment_id: 150
:comment_name: "Ticket #46"
:ticket_id: 46
:ticket_summary: Test for Brad
', 'f', '2016-04-07 08:45:34', '2016-04-07 08:45:34', 580);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (720, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #47: Test for Brad) added"
:by: Monty K.
:by_id: 5
:comment_id: 150
:comment_name: "Ticket #46"
:ticket_id: 46
:ticket_summary: Test for Brad
', 'f', '2016-04-07 08:45:34', '2016-04-07 08:45:34', 580);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (721, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test for Teresa
:ticket_id: 48
', 'f', '2016-04-07 08:54:56', '2016-04-07 08:54:56', 581);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (722, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Scott W.
:by_id: 4
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test for Teresa
:ticket_id: 48
', 'f', '2016-04-07 09:01:01', '2016-04-07 09:01:01', 582);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (723, 'user_created', '--- 
:source: :user
:user_email: customerservice@kelsan.biz
:user_id: 36
', 'f', '2016-04-07 09:03:11', '2016-04-07 09:03:11', 583);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (724, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 151
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:03:11', '2016-04-07 09:03:11', 584);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (725, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 151
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:03:11', '2016-04-07 09:03:11', 584);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (726, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 151
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:03:11', '2016-04-07 09:03:11', 584);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (727, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 151
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:03:11', '2016-04-07 09:03:11', 584);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (728, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Elizabeth
:ticket_id: 49
', 'f', '2016-04-07 09:03:11', '2016-04-07 09:03:11', 585);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (729, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  A new ticket has been received by the Kelsan Customer Service Help Desk system.
  
  Someone will contact you shortly.
  
  TICKET #49
  
  Summary: Test for Elizabeth
  
  Description:
  
  Monty Kilburn | Director of Marketing
  
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
  
   |
  
  Ticket History
  
  _______________________________
:by: customerservice
:by_id: 36
:comment_id: 152
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:04:11', '2016-04-07 09:04:11', 586);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (730, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  A new ticket has been received by the Kelsan Customer Service Help Desk system.
  
  Someone will contact you shortly.
  
  TICKET #49
  
  Summary: Test for Elizabeth
  
  Description:
  
  Monty Kilburn | Director of Marketing
  
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
  
   |
  
  Ticket History
  
  _______________________________
:by: customerservice
:by_id: 36
:comment_id: 152
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:04:11', '2016-04-07 09:04:11', 586);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (731, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  A new ticket has been received by the Kelsan Customer Service Help Desk system.
  
  Someone will contact you shortly.
  
  TICKET #49
  
  Summary: Test for Elizabeth
  
  Description:
  
  Monty Kilburn | Director of Marketing
  
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
  
   |
  
  Ticket History
  
  _______________________________
:by: customerservice
:by_id: 36
:comment_id: 152
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:04:11', '2016-04-07 09:04:11', 586);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (732, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: customerservice
:by_id: 36
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Elizabeth
:ticket_id: 49
', 'f', '2016-04-07 09:04:11', '2016-04-07 09:04:11', 587);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (733, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Scott W.
:by_id: 4
:comment_id: 154
:comment_name: "Ticket #50"
:ticket_id: 50
:ticket_summary: Ticket Help Desk
', 'f', '2016-04-07 09:12:11', '2016-04-07 09:12:11', 588);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (734, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Scott W.
:by_id: 4
:comment_id: 154
:comment_name: "Ticket #50"
:ticket_id: 50
:ticket_summary: Ticket Help Desk
', 'f', '2016-04-07 09:12:11', '2016-04-07 09:12:11', 588);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (735, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Scott W.
:by_id: 4
:comment_id: 154
:comment_name: "Ticket #50"
:ticket_id: 50
:ticket_summary: Ticket Help Desk
', 'f', '2016-04-07 09:12:11', '2016-04-07 09:12:11', 588);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (736, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Scott W.
:by_id: 4
:comment_id: 154
:comment_name: "Ticket #50"
:ticket_id: 50
:ticket_summary: Ticket Help Desk
', 'f', '2016-04-07 09:12:11', '2016-04-07 09:12:11', 588);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (737, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Ticket Help Desk
:ticket_id: 50
', 'f', '2016-04-07 09:12:11', '2016-04-07 09:12:11', 589);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (738, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  A new ticket has been received by the Kelsan Customer Service Help Desk system.
  
  Someone will contact you shortly.
  
  TICKET #50
  
  Summary: Ticket Help Desk
  
  Description:
:by: customerservice
:by_id: 36
:comment_id: 155
:comment_name: "Ticket #50"
:ticket_id: 50
:ticket_summary: Ticket Help Desk
', 'f', '2016-04-07 09:13:11', '2016-04-07 09:13:11', 590);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (739, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  A new ticket has been received by the Kelsan Customer Service Help Desk system.
  
  Someone will contact you shortly.
  
  TICKET #50
  
  Summary: Ticket Help Desk
  
  Description:
:by: customerservice
:by_id: 36
:comment_id: 155
:comment_name: "Ticket #50"
:ticket_id: 50
:ticket_summary: Ticket Help Desk
', 'f', '2016-04-07 09:13:11', '2016-04-07 09:13:11', 590);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (740, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  A new ticket has been received by the Kelsan Customer Service Help Desk system.
  
  Someone will contact you shortly.
  
  TICKET #50
  
  Summary: Ticket Help Desk
  
  Description:
:by: customerservice
:by_id: 36
:comment_id: 155
:comment_name: "Ticket #50"
:ticket_id: 50
:ticket_summary: Ticket Help Desk
', 'f', '2016-04-07 09:13:11', '2016-04-07 09:13:11', 590);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (741, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: customerservice
:by_id: 36
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Ticket Help Desk
:ticket_id: 50
', 'f', '2016-04-07 09:13:11', '2016-04-07 09:13:11', 591);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (742, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Ticket Help Desk
:ticket_id: 50
', 'f', '2016-04-07 09:14:19', '2016-04-07 09:14:19', 592);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (743, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Elizabeth
:ticket_id: 49
', 'f', '2016-04-07 09:14:25', '2016-04-07 09:14:25', 592);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (744, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 157
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:14:29', '2016-04-07 09:14:29', 593);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (745, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Elizabeth
:ticket_id: 49
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-04-07 09:14:29', '2016-04-07 09:14:29', 594);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (746, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 157
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:14:29', '2016-04-07 09:14:29', 595);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (747, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Elizabeth
:ticket_id: 49
', 'f', '2016-04-07 09:14:29', '2016-04-07 09:14:29', 596);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (748, 'ticket_comment_added', '--- 
:body: I see it.
:by: Elizabeth H.
:by_id: 9
:comment_id: 158
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:14:42', '2016-04-07 09:14:42', 597);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (749, 'ticket_comment_added', '--- 
:body: I see it.
:by: Elizabeth H.
:by_id: 9
:comment_id: 158
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:14:42', '2016-04-07 09:14:42', 597);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (750, 'ticket_comment_added', '--- 
:body: Thank you for helping me. Can you close the ticket?
:by: Monty K.
:by_id: 5
:comment_id: 159
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:17:10', '2016-04-07 09:17:10', 597);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (751, 'ticket_comment_added', '--- 
:body: Thank you for helping me. Can you close the ticket?
:by: Monty K.
:by_id: 5
:comment_id: 159
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:17:10', '2016-04-07 09:17:10', 597);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (752, 'ticket_opened', '--- 
:assigned_to: Elizabeth H.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Elizabeth
:ticket_id: 49
', 'f', '2016-04-07 09:17:10', '2016-04-07 09:17:10', 598);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (753, 'ticket_comment_added', '--- 
:body: |-
  How do I get back to it?
  
  Elizabeth Heaton | Inside Sales
  
  P 865.525.7132 ext. 667 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
:by: Elizabeth H.
:by_id: 9
:comment_id: 160
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:19:10', '2016-04-07 09:19:10', 599);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (754, 'ticket_comment_added', '--- 
:body: |-
  How do I get back to it?
  
  Elizabeth Heaton | Inside Sales
  
  P 865.525.7132 ext. 667 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
:by: Elizabeth H.
:by_id: 9
:comment_id: 160
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:19:10', '2016-04-07 09:19:10', 599);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (755, 'ticket_comment_added', '--- 
:body: |-
  How do I get back to it?
  
  Elizabeth Heaton | Inside Sales
  
  P 865.525.7132 ext. 667 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
:by: Elizabeth H.
:by_id: 9
:comment_id: 160
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:19:10', '2016-04-07 09:19:10', 599);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (756, 'ticket_opened', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Elizabeth
:ticket_id: 49
', 'f', '2016-04-07 09:19:10', '2016-04-07 09:19:10', 600);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (757, 'ticket_comment_added', '--- 
:body: Did it assign to you?
:by: Monty K.
:by_id: 5
:comment_id: 162
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:21:32', '2016-04-07 09:21:32', 601);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (758, 'ticket_comment_added', '--- 
:body: Did it assign to you?
:by: Monty K.
:by_id: 5
:comment_id: 162
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:21:33', '2016-04-07 09:21:33', 601);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (759, 'ticket_opened', '--- 
:assigned_to: Elizabeth H.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Elizabeth
:ticket_id: 49
', 'f', '2016-04-07 09:21:33', '2016-04-07 09:21:33', 602);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (760, 'ticket_comment_added', '--- 
:body: "Ticket closed: Oh - figured it out."
:by: Elizabeth H.
:by_id: 9
:comment_id: 163
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:21:44', '2016-04-07 09:21:44', 603);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (761, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Elizabeth
:ticket_id: 49
', 'f', '2016-04-07 09:21:44', '2016-04-07 09:21:44', 604);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (762, 'ticket_comment_added', '--- 
:body: "Ticket closed: Oh - figured it out."
:by: Elizabeth H.
:by_id: 9
:comment_id: 163
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:21:44', '2016-04-07 09:21:44', 605);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (763, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  On Apr 07, 2016 @ 09:21 am,
  
  Ticket #49 was closed.
  
  With the comment:
  
  Ticket closed: Oh - figured it out.
  
  Please do not reply to this email unless this ticket has not been closed to your satisfaction. If you would like to thank Elizabeth Heaton, use the email link to the right.
  
  TICKET #49
  
  Summary: Test for Elizabeth
  
  Description:
  
  Monty Kilburn | Director of Marketing
  
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
  
   |
  
  Ticket History
  
  _______________________________
:by: customerservice
:by_id: 36
:comment_id: 164
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:22:11', '2016-04-07 09:22:11', 605);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (764, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  On Apr 07, 2016 @ 09:21 am,
  
  Ticket #49 was closed.
  
  With the comment:
  
  Ticket closed: Oh - figured it out.
  
  Please do not reply to this email unless this ticket has not been closed to your satisfaction. If you would like to thank Elizabeth Heaton, use the email link to the right.
  
  TICKET #49
  
  Summary: Test for Elizabeth
  
  Description:
  
  Monty Kilburn | Director of Marketing
  
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
  
   |
  
  Ticket History
  
  _______________________________
:by: customerservice
:by_id: 36
:comment_id: 164
:comment_name: "Ticket #49"
:ticket_id: 49
:ticket_summary: Test for Elizabeth
', 'f', '2016-04-07 09:22:11', '2016-04-07 09:22:11', 605);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (765, 'ticket_opened', '--- 
:assigned_to: Elizabeth H.
:by: customerservice
:by_id: 36
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Elizabeth
:ticket_id: 49
', 'f', '2016-04-07 09:22:11', '2016-04-07 09:22:11', 606);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (766, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Elizabeth
:ticket_id: 49
', 'f', '2016-04-07 09:22:16', '2016-04-07 09:22:16', 607);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (767, 'ticket_comment_added', '--- 
:body: Assigned to Scott Whitson.
:by: Scott W.
:by_id: 4
:comment_id: 165
:comment_name: "Ticket #50"
:ticket_id: 50
:ticket_summary: Ticket Help Desk
', 'f', '2016-04-07 09:29:26', '2016-04-07 09:29:26', 608);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (768, 'ticket_reassigned', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Ticket Help Desk
:ticket_id: 50
:to: Scott W.
:to_id: 4
', 'f', '2016-04-07 09:29:26', '2016-04-07 09:29:26', 609);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (769, 'ticket_comment_added', '--- 
:body: Assigned to Scott Whitson.
:by: Scott W.
:by_id: 4
:comment_id: 165
:comment_name: "Ticket #50"
:ticket_id: 50
:ticket_summary: Ticket Help Desk
', 'f', '2016-04-07 09:29:26', '2016-04-07 09:29:26', 610);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (770, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Ticket Help Desk
:ticket_id: 50
', 'f', '2016-04-07 09:29:26', '2016-04-07 09:29:26', 611);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (771, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Scott W.
:by_id: 4
:comment_id: 166
:comment_name: "Ticket #50"
:ticket_id: 50
:ticket_summary: Ticket Help Desk
', 'f', '2016-04-07 09:29:43', '2016-04-07 09:29:43', 612);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (772, 'ticket_closed', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:device_ids: []

:due_at: 
:email: swhitson@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Ticket Help Desk
:ticket_id: 50
', 'f', '2016-04-07 09:29:43', '2016-04-07 09:29:43', 613);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (773, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Scott W.
:by_id: 4
:comment_id: 166
:comment_name: "Ticket #50"
:ticket_id: 50
:ticket_summary: Ticket Help Desk
', 'f', '2016-04-07 09:29:44', '2016-04-07 09:29:44', 614);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (774, 'ticket_updated', '--- 
:assigned_to: Scott W.
:by: Scott W.
:by_id: 4
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: swhitson@kelsan.biz
:summary: Ticket Help Desk
:ticket_id: 50
', 'f', '2016-04-07 09:29:44', '2016-04-07 09:29:44', 615);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (775, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: customerservice
:by_id: 36
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: customerservice@kelsan.biz
:summary: Ticket Help Desk
:ticket_id: 51
', 'f', '2016-04-07 09:30:11', '2016-04-07 09:30:11', 616);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (776, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  A new ticket has been received by the Kelsan Customer Service Help Desk system.
  
  Someone will contact you shortly.
  
  TICKET #51
  
  Summary: Ticket Help Desk
  
  Description:
  
  Customer Service Help Desk |
  
  customerservice@kelsan.biz,
  
  On Apr 07, 2016 @ 09:29 am,
  
  Ticket #50 was closed.
  
  With the comment:
  
  Ticket closed.
  
  Please do not reply to this email unless this ticket has not been closed to your satisfaction. If you would like to thank Scott Whitson, use the email link to the right.
  
  TICKET #50
  
  Summary: Ticket Help Desk
  
  Description:
:by: customerservice
:by_id: 36
:comment_id: 167
:comment_name: "Ticket #51"
:ticket_id: 51
:ticket_summary: Ticket Help Desk
', 'f', '2016-04-07 09:31:10', '2016-04-07 09:31:10', 617);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (777, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  A new ticket has been received by the Kelsan Customer Service Help Desk system.
  
  Someone will contact you shortly.
  
  TICKET #51
  
  Summary: Ticket Help Desk
  
  Description:
  
  Customer Service Help Desk |
  
  customerservice@kelsan.biz,
  
  On Apr 07, 2016 @ 09:29 am,
  
  Ticket #50 was closed.
  
  With the comment:
  
  Ticket closed.
  
  Please do not reply to this email unless this ticket has not been closed to your satisfaction. If you would like to thank Scott Whitson, use the email link to the right.
  
  TICKET #50
  
  Summary: Ticket Help Desk
  
  Description:
:by: customerservice
:by_id: 36
:comment_id: 167
:comment_name: "Ticket #51"
:ticket_id: 51
:ticket_summary: Ticket Help Desk
', 'f', '2016-04-07 09:31:10', '2016-04-07 09:31:10', 617);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (778, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: customerservice
:by_id: 36
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: customerservice@kelsan.biz
:summary: Ticket Help Desk
:ticket_id: 51
', 'f', '2016-04-07 09:31:10', '2016-04-07 09:31:10', 618);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (779, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Scott W.
:by_id: 4
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: customerservice@kelsan.biz
:summary: Ticket Help Desk
:ticket_id: 51
', 'f', '2016-04-07 09:47:41', '2016-04-07 09:47:41', 619);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (780, 'ticket_comment_added', '--- 
:body: Assigned to Operations Help Desk.
:by: Elizabeth H.
:by_id: 9
:comment_id: 168
:comment_name: "Ticket #52"
:ticket_id: 52
:ticket_summary: test
', 'f', '2016-04-07 09:56:26', '2016-04-07 09:56:26', 620);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (781, 'ticket_reassigned', '--- 
:assigned_to: Operations H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 52
:to: Operations H.
:to_id: 34
', 'f', '2016-04-07 09:56:26', '2016-04-07 09:56:26', 621);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (782, 'ticket_comment_added', '--- 
:body: Assigned to Operations Help Desk.
:by: Elizabeth H.
:by_id: 9
:comment_id: 168
:comment_name: "Ticket #52"
:ticket_id: 52
:ticket_summary: test
', 'f', '2016-04-07 09:56:26', '2016-04-07 09:56:26', 622);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (783, 'ticket_opened', '--- 
:assigned_to: Operations H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 52
', 'f', '2016-04-07 09:56:26', '2016-04-07 09:56:26', 623);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (784, 'ticket_updated', '--- 
:assigned_to: Operations H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 52
', 'f', '2016-04-07 09:56:54', '2016-04-07 09:56:54', 624);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (785, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 169
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:06:11', '2016-04-07 10:06:11', 625);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (786, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 169
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:06:11', '2016-04-07 10:06:11', 625);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (787, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 169
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:06:11', '2016-04-07 10:06:11', 625);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (788, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 169
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:06:11', '2016-04-07 10:06:11', 625);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (789, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 169
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:06:11', '2016-04-07 10:06:11', 625);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (790, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: order
:ticket_id: 53
', 'f', '2016-04-07 10:06:11', '2016-04-07 10:06:11', 626);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (791, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  A new ticket has been received by the Kelsan Customer Service Help Desk system.
  
  Someone will contact you shortly.
  
  TICKET #53
  
  Summary: order
  
  Description:
  
  Hey, I have order that needs to go out for this customer. Montykilburn@gmail.com
  
  Monty Kilburn | Director of Marketing
  
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
  
   |
  
  Ticket History
  
  _______________________________
:by: customerservice
:by_id: 36
:comment_id: 170
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:07:11', '2016-04-07 10:07:11', 627);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (792, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: customerservice
:by_id: 36
:comment_id: 171
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:07:11', '2016-04-07 10:07:11', 627);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (793, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  A new ticket has been received by the Kelsan Customer Service Help Desk system.
  
  Someone will contact you shortly.
  
  TICKET #53
  
  Summary: order
  
  Description:
  
  Hey, I have order that needs to go out for this customer. Montykilburn@gmail.com
  
  Monty Kilburn | Director of Marketing
  
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
  
   |
  
  Ticket History
  
  _______________________________
:by: customerservice
:by_id: 36
:comment_id: 170
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:07:11', '2016-04-07 10:07:11', 627);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (794, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: customerservice
:by_id: 36
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: order
:ticket_id: 53
', 'f', '2016-04-07 10:07:11', '2016-04-07 10:07:11', 628);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (795, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: order
:ticket_id: 53
', 'f', '2016-04-07 10:08:30', '2016-04-07 10:08:30', 629);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (796, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 172
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:08:37', '2016-04-07 10:08:37', 630);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (797, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: order
:ticket_id: 53
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-04-07 10:08:37', '2016-04-07 10:08:37', 631);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (798, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 172
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:08:37', '2016-04-07 10:08:37', 632);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (799, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: order
:ticket_id: 53
', 'f', '2016-04-07 10:08:37', '2016-04-07 10:08:37', 633);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (800, 'ticket_comment_added', '--- 
:body: Order number blah blah blah
:by: Elizabeth H.
:by_id: 9
:comment_id: 173
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:09:44', '2016-04-07 10:09:44', 634);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (801, 'ticket_comment_added', '--- 
:body: Order number blah blah blah
:by: Elizabeth H.
:by_id: 9
:comment_id: 173
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:09:44', '2016-04-07 10:09:44', 634);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (802, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 174
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:09:49', '2016-04-07 10:09:49', 634);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (803, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: order
:ticket_id: 53
', 'f', '2016-04-07 10:09:49', '2016-04-07 10:09:49', 635);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (804, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 174
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:09:49', '2016-04-07 10:09:49', 636);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (805, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: order
:ticket_id: 53
', 'f', '2016-04-07 10:09:49', '2016-04-07 10:09:49', 637);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (806, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  On Apr 07, 2016 @ 10:09 am,
  
  Ticket #53 was closed.
  
  With the comment:
  
  Ticket closed.
  
  Please do not reply to this email unless this ticket has not been closed to your satisfaction. If you would like to thank Elizabeth Heaton, use the email link to the right.
  
  TICKET #53
  
  Summary: order
  
  Description:
  
  Hey, I have order that needs to go out for this customer. Montykilburn@gmail.com
  
  Monty Kilburn | Director of Marketing
  
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
  
   |
  
  Ticket History
  
  _______________________________
:by: customerservice
:by_id: 36
:comment_id: 175
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:10:11', '2016-04-07 10:10:11', 638);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (807, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  On Apr 07, 2016 @ 10:09 am,
  
  Ticket #53 was closed.
  
  With the comment:
  
  Ticket closed.
  
  Please do not reply to this email unless this ticket has not been closed to your satisfaction. If you would like to thank Elizabeth Heaton, use the email link to the right.
  
  TICKET #53
  
  Summary: order
  
  Description:
  
  Hey, I have order that needs to go out for this customer. Montykilburn@gmail.com
  
  Monty Kilburn | Director of Marketing
  
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
  
   |
  
  Ticket History
  
  _______________________________
:by: customerservice
:by_id: 36
:comment_id: 175
:comment_name: "Ticket #53"
:ticket_id: 53
:ticket_summary: order
', 'f', '2016-04-07 10:10:11', '2016-04-07 10:10:11', 638);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (808, 'ticket_opened', '--- 
:assigned_to: Elizabeth H.
:by: customerservice
:by_id: 36
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: order
:ticket_id: 53
', 'f', '2016-04-07 10:10:11', '2016-04-07 10:10:11', 639);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (809, 'user_updated', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:updated: 
  role: end_user
:user_email: tfarmer@kelsan.biz
:user_id: 19
', 'f', '2016-04-07 10:24:40', '2016-04-07 10:24:40', 640);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (810, 'user_updated', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:updated: 
  role: helpdesk_tech
:user_email: tfarmer@kelsan.biz
:user_id: 19
', 'f', '2016-04-07 10:25:05', '2016-04-07 10:25:05', 640);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (811, 'user_updated', '--- 
:by: Reymund E.
:by_id: 20
:source: :user
:updated: 
  role: helpdesk_admin
:user_email: tfarmer@kelsan.biz
:user_id: 19
', 'f', '2016-04-07 10:40:16', '2016-04-07 10:40:16', 640);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (812, 'user_created', '--- 
:source: :user
:user_email: no-reply@wufoo.com
:user_id: 37
', 'f', '2016-04-07 10:44:10', '2016-04-07 10:44:10', 641);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (813, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: no-reply
:by_id: 37
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#582]
:ticket_id: 54
', 'f', '2016-04-07 10:44:11', '2016-04-07 10:44:11', 642);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (814, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  A new ticket has been received by the Kelsan Customer Service Help Desk system.
  
  Someone will contact you shortly.
  
  TICKET #54
  
  Summary: Connect With Us [#582]
  
  Description:
  
  Source |
  kelsan.biz - contact us form
  |
  I''m Interested In: * |
  Customer Service
  |
  Name * | Reymund Edrosolano |
  Email * | redrosolano@kelsan.biz |
  Message: * |
  test ticket.... 1043am 070716
  |
  
   |
  
   |
  TICKET #54
  _______________________________
  Date: Apr 07, 2016 @ 10:44 am
  
  Creator: no-reply@wufoo.com
  
  Summary: Connect With Us [#582]
  
  Priority: Med
  
  Ticket URL: Ticket #54
  
  Assignee:
  
  CC:
  _______________________________
  
  If you have additional information regarding this ticket, please send your response to customerservice@kelsan.biz. Remember to keep [TICKET #] in the email subject.
  
   |
:by: customerservice
:by_id: 36
:comment_id: 176
:comment_name: "Ticket #54"
:ticket_id: 54
:ticket_summary: Connect With Us [#582]
', 'f', '2016-04-07 10:44:27', '2016-04-07 10:44:27', 643);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (815, 'ticket_comment_added', '--- 
:body: |-
  Customer Service Help Desk  |
  
  customerservice@kelsan.biz,
  
  A new ticket has been received by the Kelsan Customer Service Help Desk system.
  
  Someone will contact you shortly.
  
  TICKET #54
  
  Summary: Connect With Us [#582]
  
  Description:
  
  Source |
  kelsan.biz - contact us form
  |
  I''m Interested In: * |
  Customer Service
  |
  Name * | Reymund Edrosolano |
  Email * | redrosolano@kelsan.biz |
  Message: * |
  test ticket.... 1043am 070716
  |
  
   |
  
   |
  TICKET #54
  _______________________________
  Date: Apr 07, 2016 @ 10:44 am
  
  Creator: no-reply@wufoo.com
  
  Summary: Connect With Us [#582]
  
  Priority: Med
  
  Ticket URL: Ticket #54
  
  Assignee:
  
  CC:
  _______________________________
  
  If you have additional information regarding this ticket, please send your response to customerservice@kelsan.biz. Remember to keep [TICKET #] in the email subject.
  
   |
:by: customerservice
:by_id: 36
:comment_id: 176
:comment_name: "Ticket #54"
:ticket_id: 54
:ticket_summary: Connect With Us [#582]
', 'f', '2016-04-07 10:44:27', '2016-04-07 10:44:27', 643);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (816, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: customerservice
:by_id: 36
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#582]
:ticket_id: 54
', 'f', '2016-04-07 10:44:27', '2016-04-07 10:44:27', 644);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (817, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Scott W.
:by_id: 4
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#582]
:ticket_id: 54
', 'f', '2016-04-07 11:16:11', '2016-04-07 11:16:11', 645);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (818, 'user_updated', '--- 
:by: Lee T.
:by_id: 3
:source: :user
:updated: 
  email: customerservicehd@kelsan.biz
:user_email: customerservicehd@kelsan.biz
:user_id: 36
', 'f', '2016-04-07 11:28:28', '2016-04-07 11:28:28', 646);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (819, 'user_updated', '--- 
:by: Lee T.
:by_id: 3
:source: :user
:updated: 
  first_name: Customer
  last_name: Service
:user_email: customerservicehd@kelsan.biz
:user_id: 36
', 'f', '2016-04-07 11:28:38', '2016-04-07 11:28:38', 646);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (820, 'user_updated', '--- 
:by: Lee T.
:by_id: 3
:source: :user
:updated: 
  role: admin
:user_email: customerservicehd@kelsan.biz
:user_id: 36
', 'f', '2016-04-07 11:28:38', '2016-04-07 11:28:38', 646);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (821, 'ticket_comment_added', '--- 
:body: Assigned to Teresa Farmer.
:by: Teresa F.
:by_id: 19
:comment_id: 177
:comment_name: "Ticket #54"
:ticket_id: 54
:ticket_summary: Connect With Us [#582]
', 'f', '2016-04-07 12:40:34', '2016-04-07 12:40:34', 647);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (822, 'ticket_reassigned', '--- 
:assigned_to: Teresa F.
:by: Teresa F.
:by_id: 19
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#582]
:ticket_id: 54
:to: Teresa F.
:to_id: 19
', 'f', '2016-04-07 12:40:34', '2016-04-07 12:40:34', 648);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (823, 'ticket_comment_added', '--- 
:body: Assigned to Teresa Farmer.
:by: Teresa F.
:by_id: 19
:comment_id: 177
:comment_name: "Ticket #54"
:ticket_id: 54
:ticket_summary: Connect With Us [#582]
', 'f', '2016-04-07 12:40:34', '2016-04-07 12:40:34', 649);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (824, 'ticket_updated', '--- 
:assigned_to: Teresa F.
:by: Teresa F.
:by_id: 19
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#582]
:ticket_id: 54
', 'f', '2016-04-07 12:40:34', '2016-04-07 12:40:34', 650);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (825, 'user_updated', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:updated: 
  role: end_user
:user_email: bcraig@kelsan.biz
:user_id: 33
', 'f', '2016-04-07 12:40:53', '2016-04-07 12:40:53', 651);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (826, 'user_updated', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:updated: 
  role: helpdesk_tech
:user_email: bcraig@kelsan.biz
:user_id: 33
', 'f', '2016-04-07 12:41:21', '2016-04-07 12:41:21', 651);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (827, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 178
:comment_name: "Ticket #48"
:ticket_id: 48
:ticket_summary: test for Teresa
', 'f', '2016-04-07 12:58:46', '2016-04-07 12:58:46', 652);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (828, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test for Teresa
:ticket_id: 48
:to: Monty K.
:to_id: 5
', 'f', '2016-04-07 12:58:46', '2016-04-07 12:58:46', 653);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (829, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 178
:comment_name: "Ticket #48"
:ticket_id: 48
:ticket_summary: test for Teresa
', 'f', '2016-04-07 12:58:46', '2016-04-07 12:58:46', 654);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (830, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test for Teresa
:ticket_id: 48
', 'f', '2016-04-07 12:58:46', '2016-04-07 12:58:46', 655);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (831, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 179
:comment_name: "Ticket #48"
:ticket_id: 48
:ticket_summary: test for Teresa
', 'f', '2016-04-07 12:58:47', '2016-04-07 12:58:47', 656);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (832, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test for Teresa
:ticket_id: 48
', 'f', '2016-04-07 12:58:47', '2016-04-07 12:58:47', 657);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (833, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 179
:comment_name: "Ticket #48"
:ticket_id: 48
:ticket_summary: test for Teresa
', 'f', '2016-04-07 12:58:47', '2016-04-07 12:58:47', 658);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (834, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test for Teresa
:ticket_id: 48
', 'f', '2016-04-07 12:58:47', '2016-04-07 12:58:47', 659);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (835, 'ticket_comment_added', '--- 
:body: Assigned to Brad Craig.
:by: Monty K.
:by_id: 5
:comment_id: 180
:comment_name: "Ticket #55"
:ticket_id: 55
:ticket_summary: test
', 'f', '2016-04-07 13:02:13', '2016-04-07 13:02:13', 660);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (836, 'ticket_reassigned', '--- 
:assigned_to: Brad C.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 55
:to: Brad C.
:to_id: 33
', 'f', '2016-04-07 13:02:13', '2016-04-07 13:02:13', 661);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (837, 'ticket_comment_added', '--- 
:body: Assigned to Brad Craig.
:by: Monty K.
:by_id: 5
:comment_id: 180
:comment_name: "Ticket #55"
:ticket_id: 55
:ticket_summary: test
', 'f', '2016-04-07 13:02:13', '2016-04-07 13:02:13', 662);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (838, 'ticket_opened', '--- 
:assigned_to: Brad C.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 55
', 'f', '2016-04-07 13:02:13', '2016-04-07 13:02:13', 663);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (839, 'user_updated', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:updated: 
  role: helpdesk_admin
:user_email: bcraig@kelsan.biz
:user_id: 33
', 'f', '2016-04-07 13:03:18', '2016-04-07 13:03:18', 664);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (840, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 181
:comment_name: "Ticket #56"
:ticket_id: 56
:ticket_summary: Delivery issue
', 'f', '2016-04-07 13:07:10', '2016-04-07 13:07:10', 665);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (841, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 181
:comment_name: "Ticket #56"
:ticket_id: 56
:ticket_summary: Delivery issue
', 'f', '2016-04-07 13:07:10', '2016-04-07 13:07:10', 665);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (842, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 181
:comment_name: "Ticket #56"
:ticket_id: 56
:ticket_summary: Delivery issue
', 'f', '2016-04-07 13:07:10', '2016-04-07 13:07:10', 665);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (843, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 181
:comment_name: "Ticket #56"
:ticket_id: 56
:ticket_summary: Delivery issue
', 'f', '2016-04-07 13:07:10', '2016-04-07 13:07:10', 665);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (844, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Delivery issue
:ticket_id: 56
', 'f', '2016-04-07 13:07:11', '2016-04-07 13:07:11', 666);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (845, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Delivery issue
:ticket_id: 56
', 'f', '2016-04-07 13:07:22', '2016-04-07 13:07:22', 667);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (846, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 182
:comment_name: "Ticket #56"
:ticket_id: 56
:ticket_summary: Delivery issue
', 'f', '2016-04-07 13:09:48', '2016-04-07 13:09:48', 668);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (847, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Delivery issue
:ticket_id: 56
:to: Monty K.
:to_id: 5
', 'f', '2016-04-07 13:09:48', '2016-04-07 13:09:48', 669);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (848, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 182
:comment_name: "Ticket #56"
:ticket_id: 56
:ticket_summary: Delivery issue
', 'f', '2016-04-07 13:09:48', '2016-04-07 13:09:48', 670);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (849, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Delivery issue
:ticket_id: 56
', 'f', '2016-04-07 13:09:48', '2016-04-07 13:09:48', 671);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (850, 'ticket_comment_added', '--- 
:body: Assigned to Operations Help Desk.
:by: Monty K.
:by_id: 5
:comment_id: 183
:comment_name: "Ticket #57"
:ticket_id: 57
:ticket_summary: "Delivery Issue with Customer #212222"
', 'f', '2016-04-07 13:11:11', '2016-04-07 13:11:11', 672);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (851, 'ticket_reassigned', '--- 
:assigned_to: Operations H.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: "Delivery Issue with Customer #212222"
:ticket_id: 57
:to: Operations H.
:to_id: 34
', 'f', '2016-04-07 13:11:11', '2016-04-07 13:11:11', 673);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (852, 'ticket_comment_added', '--- 
:body: Assigned to Operations Help Desk.
:by: Monty K.
:by_id: 5
:comment_id: 183
:comment_name: "Ticket #57"
:ticket_id: 57
:ticket_summary: "Delivery Issue with Customer #212222"
', 'f', '2016-04-07 13:11:11', '2016-04-07 13:11:11', 674);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (853, 'ticket_opened', '--- 
:assigned_to: Operations H.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: "Delivery Issue with Customer #212222"
:ticket_id: 57
', 'f', '2016-04-07 13:11:11', '2016-04-07 13:11:11', 675);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (854, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #57: Delivery Issue with Customer #212222) added"
:by: Monty K.
:by_id: 5
:comment_id: 184
:comment_name: "Ticket #56"
:ticket_id: 56
:ticket_summary: Delivery issue
', 'f', '2016-04-07 13:11:11', '2016-04-07 13:11:11', 676);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (855, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #57: Delivery Issue with Customer #212222) added"
:by: Monty K.
:by_id: 5
:comment_id: 184
:comment_name: "Ticket #56"
:ticket_id: 56
:ticket_summary: Delivery issue
', 'f', '2016-04-07 13:11:11', '2016-04-07 13:11:11', 676);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (856, 'ticket_comment_added', '--- 
:body: Unassigned.
:by: Monty K.
:by_id: 5
:comment_id: 185
:comment_name: "Ticket #47"
:ticket_id: 47
:ticket_summary: Test for Brad
', 'f', '2016-04-07 13:16:14', '2016-04-07 13:16:14', 676);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (857, 'ticket_reassigned', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Brad
:ticket_id: 47
:to: nobody
:to_id: 
', 'f', '2016-04-07 13:16:14', '2016-04-07 13:16:14', 677);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (858, 'ticket_comment_added', '--- 
:body: Unassigned.
:by: Monty K.
:by_id: 5
:comment_id: 185
:comment_name: "Ticket #47"
:ticket_id: 47
:ticket_summary: Test for Brad
', 'f', '2016-04-07 13:16:14', '2016-04-07 13:16:14', 678);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (859, 'ticket_comment_added', '--- 
:body: Unassigned.
:by: Monty K.
:by_id: 5
:comment_id: 186
:comment_name: "Ticket #52"
:ticket_id: 52
:ticket_summary: test
', 'f', '2016-04-07 13:16:14', '2016-04-07 13:16:14', 678);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (860, 'ticket_reassigned', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 52
:to: nobody
:to_id: 
', 'f', '2016-04-07 13:16:14', '2016-04-07 13:16:14', 679);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (861, 'ticket_comment_added', '--- 
:body: Unassigned.
:by: Monty K.
:by_id: 5
:comment_id: 186
:comment_name: "Ticket #52"
:ticket_id: 52
:ticket_summary: test
', 'f', '2016-04-07 13:16:14', '2016-04-07 13:16:14', 680);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (862, 'ticket_comment_added', '--- 
:body: Unassigned.
:by: Monty K.
:by_id: 5
:comment_id: 187
:comment_name: "Ticket #57"
:ticket_id: 57
:ticket_summary: "Delivery Issue with Customer #212222"
', 'f', '2016-04-07 13:16:14', '2016-04-07 13:16:14', 680);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (863, 'ticket_reassigned', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: "Delivery Issue with Customer #212222"
:ticket_id: 57
:to: nobody
:to_id: 
', 'f', '2016-04-07 13:16:14', '2016-04-07 13:16:14', 681);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (864, 'ticket_comment_added', '--- 
:body: Unassigned.
:by: Monty K.
:by_id: 5
:comment_id: 187
:comment_name: "Ticket #57"
:ticket_id: 57
:ticket_summary: "Delivery Issue with Customer #212222"
', 'f', '2016-04-07 13:16:14', '2016-04-07 13:16:14', 682);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (865, 'user_updated', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:updated: 
  role: end_user
:user_email: opshelp@kelsan.biz
:user_id: 34
', 'f', '2016-04-07 13:16:15', '2016-04-07 13:16:15', 683);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (866, 'user_updated', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:updated: 
  role: helpdesk_tech
:user_email: bcraig@kelsan.biz
:user_id: 33
', 'f', '2016-04-07 13:17:06', '2016-04-07 13:17:06', 683);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (867, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Brad C.
:by_id: 33
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
  summary: 
  - Ticket Help Desk
  - "654165465"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: customerservicehd@kelsan.biz
:summary: "654165465"
:ticket_id: 51
', 'f', '2016-04-07 13:17:40', '2016-04-07 13:17:40', 684);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (868, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Brad C.
:by_id: 33
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: customerservicehd@kelsan.biz
:summary: "654165465"
:ticket_id: 51
', 'f', '2016-04-07 13:17:49', '2016-04-07 13:17:49', 684);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (869, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Brad C.
:by_id: 33
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: customerservicehd@kelsan.biz
:summary: "654165465"
:ticket_id: 51
', 'f', '2016-04-07 13:17:57', '2016-04-07 13:17:57', 684);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (870, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Brad C.
:by_id: 33
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: customerservicehd@kelsan.biz
:summary: "654165465"
:ticket_id: 51
', 'f', '2016-04-07 13:17:58', '2016-04-07 13:17:58', 684);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (871, 'user_updated', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:updated: 
  role: helpdesk_admin
:user_email: bcraig@kelsan.biz
:user_id: 33
', 'f', '2016-04-07 13:19:03', '2016-04-07 13:19:03', 685);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (872, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 188
:comment_name: "Ticket #57"
:ticket_id: 57
:ticket_summary: "Delivery Issue with Customer #212222"
', 'f', '2016-04-07 13:19:25', '2016-04-07 13:19:25', 686);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (873, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: "Delivery Issue with Customer #212222"
:ticket_id: 57
:to: Monty K.
:to_id: 5
', 'f', '2016-04-07 13:19:25', '2016-04-07 13:19:25', 687);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (874, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 188
:comment_name: "Ticket #57"
:ticket_id: 57
:ticket_summary: "Delivery Issue with Customer #212222"
', 'f', '2016-04-07 13:19:25', '2016-04-07 13:19:25', 688);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (875, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: "Delivery Issue with Customer #212222"
:ticket_id: 57
', 'f', '2016-04-07 13:19:25', '2016-04-07 13:19:25', 689);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (876, 'ticket_comment_added', '--- 
:body: Assigned to Brad Craig.
:by: Monty K.
:by_id: 5
:comment_id: 189
:comment_name: "Ticket #57"
:ticket_id: 57
:ticket_summary: "Delivery Issue with Customer #212222"
', 'f', '2016-04-07 13:19:45', '2016-04-07 13:19:45', 690);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (877, 'ticket_reassigned', '--- 
:assigned_to: Brad C.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: "Delivery Issue with Customer #212222"
:ticket_id: 57
:to: Brad C.
:to_id: 33
', 'f', '2016-04-07 13:19:45', '2016-04-07 13:19:45', 691);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (878, 'ticket_comment_added', '--- 
:body: Assigned to Brad Craig.
:by: Monty K.
:by_id: 5
:comment_id: 189
:comment_name: "Ticket #57"
:ticket_id: 57
:ticket_summary: "Delivery Issue with Customer #212222"
', 'f', '2016-04-07 13:19:45', '2016-04-07 13:19:45', 692);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (879, 'ticket_updated', '--- 
:assigned_to: Brad C.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: "Delivery Issue with Customer #212222"
:ticket_id: 57
', 'f', '2016-04-07 13:19:45', '2016-04-07 13:19:45', 693);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (880, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 190
:comment_name: "Ticket #52"
:ticket_id: 52
:ticket_summary: test
', 'f', '2016-04-07 13:19:55', '2016-04-07 13:19:55', 694);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (881, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 52
:to: Monty K.
:to_id: 5
', 'f', '2016-04-07 13:19:56', '2016-04-07 13:19:56', 695);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (882, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 190
:comment_name: "Ticket #52"
:ticket_id: 52
:ticket_summary: test
', 'f', '2016-04-07 13:19:56', '2016-04-07 13:19:56', 696);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (883, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 52
', 'f', '2016-04-07 13:19:56', '2016-04-07 13:19:56', 697);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (884, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 191
:comment_name: "Ticket #52"
:ticket_id: 52
:ticket_summary: test
', 'f', '2016-04-07 13:19:57', '2016-04-07 13:19:57', 698);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (885, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 52
:to: Monty K.
:to_id: 5
', 'f', '2016-04-07 13:19:57', '2016-04-07 13:19:57', 699);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (886, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 192
:comment_name: "Ticket #52"
:ticket_id: 52
:ticket_summary: test
', 'f', '2016-04-07 13:19:57', '2016-04-07 13:19:57', 700);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (887, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 52
', 'f', '2016-04-07 13:19:57', '2016-04-07 13:19:57', 701);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (888, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 191
:comment_name: "Ticket #52"
:ticket_id: 52
:ticket_summary: test
', 'f', '2016-04-07 13:19:57', '2016-04-07 13:19:57', 702);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (889, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: eheaton@kelsan.biz
:summary: test
:ticket_id: 52
', 'f', '2016-04-07 13:19:58', '2016-04-07 13:19:58', 703);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (890, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 193
:comment_name: "Ticket #51"
:ticket_id: 51
:ticket_summary: "654165465"
', 'f', '2016-04-07 13:20:03', '2016-04-07 13:20:03', 704);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (891, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: customerservicehd@kelsan.biz
:summary: "654165465"
:ticket_id: 51
:to: Monty K.
:to_id: 5
', 'f', '2016-04-07 13:20:04', '2016-04-07 13:20:04', 705);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (892, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 193
:comment_name: "Ticket #51"
:ticket_id: 51
:ticket_summary: "654165465"
', 'f', '2016-04-07 13:20:04', '2016-04-07 13:20:04', 706);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (893, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: customerservicehd@kelsan.biz
:summary: "654165465"
:ticket_id: 51
', 'f', '2016-04-07 13:20:04', '2016-04-07 13:20:04', 707);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (894, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 194
:comment_name: "Ticket #51"
:ticket_id: 51
:ticket_summary: "654165465"
', 'f', '2016-04-07 13:20:35', '2016-04-07 13:20:35', 708);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (895, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: customerservicehd@kelsan.biz
:summary: "654165465"
:ticket_id: 51
', 'f', '2016-04-07 13:20:35', '2016-04-07 13:20:35', 709);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (896, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 194
:comment_name: "Ticket #51"
:ticket_id: 51
:ticket_summary: "654165465"
', 'f', '2016-04-07 13:20:35', '2016-04-07 13:20:35', 710);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (897, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: customerservicehd@kelsan.biz
:summary: "654165465"
:ticket_id: 51
', 'f', '2016-04-07 13:20:35', '2016-04-07 13:20:35', 711);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (898, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 195
:comment_name: "Ticket #47"
:ticket_id: 47
:ticket_summary: Test for Brad
', 'f', '2016-04-07 13:20:42', '2016-04-07 13:20:42', 712);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (899, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Brad
:ticket_id: 47
:to: Monty K.
:to_id: 5
', 'f', '2016-04-07 13:20:43', '2016-04-07 13:20:43', 713);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (900, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 195
:comment_name: "Ticket #47"
:ticket_id: 47
:ticket_summary: Test for Brad
', 'f', '2016-04-07 13:20:43', '2016-04-07 13:20:43', 714);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (901, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Brad
:ticket_id: 47
', 'f', '2016-04-07 13:20:43', '2016-04-07 13:20:43', 715);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (902, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #47: Test for Brad) closed"
:by: Monty K.
:by_id: 5
:comment_id: 196
:comment_name: "Ticket #46"
:ticket_id: 46
:ticket_summary: Test for Brad
', 'f', '2016-04-07 13:20:44', '2016-04-07 13:20:44', 716);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (903, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #47: Test for Brad) closed"
:by: Monty K.
:by_id: 5
:comment_id: 196
:comment_name: "Ticket #46"
:ticket_id: 46
:ticket_summary: Test for Brad
', 'f', '2016-04-07 13:20:45', '2016-04-07 13:20:45', 716);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (904, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 197
:comment_name: "Ticket #47"
:ticket_id: 47
:ticket_summary: Test for Brad
', 'f', '2016-04-07 13:20:45', '2016-04-07 13:20:45', 716);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (905, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Brad
:ticket_id: 47
', 'f', '2016-04-07 13:20:45', '2016-04-07 13:20:45', 717);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (906, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 197
:comment_name: "Ticket #47"
:ticket_id: 47
:ticket_summary: Test for Brad
', 'f', '2016-04-07 13:20:45', '2016-04-07 13:20:45', 718);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (907, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Brad
:ticket_id: 47
', 'f', '2016-04-07 13:20:45', '2016-04-07 13:20:45', 719);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (908, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 198
:comment_name: "Ticket #46"
:ticket_id: 46
:ticket_summary: Test for Brad
', 'f', '2016-04-07 13:20:49', '2016-04-07 13:20:49', 720);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (909, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Brad
:ticket_id: 46
', 'f', '2016-04-07 13:20:50', '2016-04-07 13:20:50', 721);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (910, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 198
:comment_name: "Ticket #46"
:ticket_id: 46
:ticket_summary: Test for Brad
', 'f', '2016-04-07 13:20:50', '2016-04-07 13:20:50', 722);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (911, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Brad
:ticket_id: 46
', 'f', '2016-04-07 13:20:50', '2016-04-07 13:20:50', 723);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (912, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 199
:comment_name: "Ticket #41"
:ticket_id: 41
:ticket_summary: Testing-Jade
', 'f', '2016-04-07 13:20:56', '2016-04-07 13:20:56', 724);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (913, 'ticket_closed', '--- 
:assigned_to: Jade J.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: jjohnston@kelsan.biz
:summary: Testing-Jade
:ticket_id: 41
', 'f', '2016-04-07 13:20:56', '2016-04-07 13:20:56', 725);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (914, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 199
:comment_name: "Ticket #41"
:ticket_id: 41
:ticket_summary: Testing-Jade
', 'f', '2016-04-07 13:20:56', '2016-04-07 13:20:56', 726);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (915, 'ticket_updated', '--- 
:assigned_to: Jade J.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: jjohnston@kelsan.biz
:summary: Testing-Jade
:ticket_id: 41
', 'f', '2016-04-07 13:20:56', '2016-04-07 13:20:56', 727);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (916, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 200
:comment_name: "Ticket #55"
:ticket_id: 55
:ticket_summary: test
', 'f', '2016-04-07 13:21:06', '2016-04-07 13:21:06', 728);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (917, 'ticket_closed', '--- 
:assigned_to: Brad C.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 55
', 'f', '2016-04-07 13:21:06', '2016-04-07 13:21:06', 729);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (918, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 200
:comment_name: "Ticket #55"
:ticket_id: 55
:ticket_summary: test
', 'f', '2016-04-07 13:21:06', '2016-04-07 13:21:06', 730);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (919, 'ticket_updated', '--- 
:assigned_to: Brad C.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 55
', 'f', '2016-04-07 13:21:06', '2016-04-07 13:21:06', 731);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (920, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #57: Delivery Issue with Customer #212222) closed"
:by: Brad C.
:by_id: 33
:comment_id: 201
:comment_name: "Ticket #56"
:ticket_id: 56
:ticket_summary: Delivery issue
', 'f', '2016-04-07 13:25:00', '2016-04-07 13:25:00', 732);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (921, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #57: Delivery Issue with Customer #212222) closed"
:by: Brad C.
:by_id: 33
:comment_id: 201
:comment_name: "Ticket #56"
:ticket_id: 56
:ticket_summary: Delivery issue
', 'f', '2016-04-07 13:25:00', '2016-04-07 13:25:00', 732);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (922, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Brad C.
:by_id: 33
:comment_id: 202
:comment_name: "Ticket #57"
:ticket_id: 57
:ticket_summary: "Delivery Issue with Customer #212222"
', 'f', '2016-04-07 13:25:00', '2016-04-07 13:25:00', 732);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (923, 'ticket_closed', '--- 
:assigned_to: Brad C.
:by: Brad C.
:by_id: 33
:device_ids: []

:due_at: 
:email: bcraig@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: "Delivery Issue with Customer #212222"
:ticket_id: 57
', 'f', '2016-04-07 13:25:00', '2016-04-07 13:25:00', 733);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (924, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Brad C.
:by_id: 33
:comment_id: 202
:comment_name: "Ticket #57"
:ticket_id: 57
:ticket_summary: "Delivery Issue with Customer #212222"
', 'f', '2016-04-07 13:25:00', '2016-04-07 13:25:00', 734);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (925, 'ticket_updated', '--- 
:assigned_to: Brad C.
:by: Brad C.
:by_id: 33
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: "Delivery Issue with Customer #212222"
:ticket_id: 57
', 'f', '2016-04-07 13:25:00', '2016-04-07 13:25:00', 735);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (926, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 203
:comment_name: "Ticket #56"
:ticket_id: 56
:ticket_summary: Delivery issue
', 'f', '2016-04-07 13:25:22', '2016-04-07 13:25:22', 736);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (927, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Delivery issue
:ticket_id: 56
', 'f', '2016-04-07 13:25:22', '2016-04-07 13:25:22', 737);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (928, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 203
:comment_name: "Ticket #56"
:ticket_id: 56
:ticket_summary: Delivery issue
', 'f', '2016-04-07 13:25:22', '2016-04-07 13:25:22', 738);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (929, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Delivery issue
:ticket_id: 56
', 'f', '2016-04-07 13:25:22', '2016-04-07 13:25:22', 739);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (930, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 204
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-07 13:42:11', '2016-04-07 13:42:11', 740);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (931, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 204
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-07 13:42:11', '2016-04-07 13:42:11', 740);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (932, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 204
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-07 13:42:11', '2016-04-07 13:42:11', 740);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (933, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-07 13:42:12', '2016-04-07 13:42:12', 741);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (934, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-07 13:42:19', '2016-04-07 13:42:19', 742);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (935, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - Unspecified
  - Customer Service
  first_sub_cat: 
  - Unspecified
  - Customer Service
  second_sub_cat: 
  - 
  - Other
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-07 13:43:58', '2016-04-07 13:43:58', 742);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (936, 'ticket_comment_added', '--- 
:body: Test for Sue
:by: Monty K.
:by_id: 5
:comment_id: 205
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-07 13:44:06', '2016-04-07 13:44:06', 743);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (937, 'ticket_comment_added', '--- 
:body: Test for Sue
:by: Monty K.
:by_id: 5
:comment_id: 205
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-07 13:44:06', '2016-04-07 13:44:06', 743);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (938, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
:to: Monty K.
:to_id: 5
', 'f', '2016-04-07 13:44:06', '2016-04-07 13:44:06', 744);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (939, 'ticket_comment_added', '--- 
:body: Test for Sue
:by: Monty K.
:by_id: 5
:comment_id: 205
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-07 13:44:06', '2016-04-07 13:44:06', 745);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (940, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Monty K.
:by_id: 5
:comment_id: 207
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-07 13:44:11', '2016-04-07 13:44:11', 745);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (941, 'ticket_reassigned', '--- 
:assigned_to: Sue S.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
:to: Sue S.
:to_id: 8
', 'f', '2016-04-07 13:44:11', '2016-04-07 13:44:11', 746);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (942, 'ticket_comment_added', '--- 
:body: Assigned to Sue Stapleton.
:by: Monty K.
:by_id: 5
:comment_id: 207
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-07 13:44:11', '2016-04-07 13:44:11', 747);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (943, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-07 13:44:11', '2016-04-07 13:44:11', 748);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (944, 'user_created', '--- 
:source: :user
:user_email: mailer-daemon@s12p02o150.mxlogic.net
:user_id: 38
', 'f', '2016-04-07 14:53:10', '2016-04-07 14:53:10', 749);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (945, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: mailer-daemon
:by_id: 38
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o150.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 59
', 'f', '2016-04-07 14:53:10', '2016-04-07 14:53:10', 750);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (946, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o150.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 59
', 'f', '2016-04-07 15:36:02', '2016-04-07 15:36:02', 751);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (947, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 208
:comment_name: "Ticket #59"
:ticket_id: 59
:ticket_summary: "Warning: could not send message for past 4 hours"
', 'f', '2016-04-07 15:39:09', '2016-04-07 15:39:09', 752);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (948, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o150.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 59
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-04-07 15:39:10', '2016-04-07 15:39:10', 753);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (949, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 208
:comment_name: "Ticket #59"
:ticket_id: 59
:ticket_summary: "Warning: could not send message for past 4 hours"
', 'f', '2016-04-07 15:39:10', '2016-04-07 15:39:10', 754);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (950, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o150.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 59
', 'f', '2016-04-07 15:39:10', '2016-04-07 15:39:10', 755);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (951, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 209
:comment_name: "Ticket #59"
:ticket_id: 59
:ticket_summary: "Warning: could not send message for past 4 hours"
', 'f', '2016-04-07 15:39:12', '2016-04-07 15:39:12', 756);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (952, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o150.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 59
', 'f', '2016-04-07 15:39:12', '2016-04-07 15:39:12', 757);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (953, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Elizabeth H.
:by_id: 9
:comment_id: 209
:comment_name: "Ticket #59"
:ticket_id: 59
:ticket_summary: "Warning: could not send message for past 4 hours"
', 'f', '2016-04-07 15:39:12', '2016-04-07 15:39:12', 758);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (954, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o150.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 59
', 'f', '2016-04-07 15:39:12', '2016-04-07 15:39:12', 759);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (955, 'ticket_comment_added', '--- 
:body: "Ticket closed: Got it."
:by: Sue S.
:by_id: 8
:comment_id: 210
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-07 16:44:25', '2016-04-07 16:44:25', 760);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (956, 'ticket_closed', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:email: sstapleton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-07 16:44:25', '2016-04-07 16:44:25', 761);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (957, 'ticket_comment_added', '--- 
:body: "Ticket closed: Got it."
:by: Sue S.
:by_id: 8
:comment_id: 210
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-07 16:44:25', '2016-04-07 16:44:25', 762);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (958, 'user_created', '--- 
:source: :user
:user_email: edi@kelsan.biz
:user_id: 39
', 'f', '2016-04-07 16:47:10', '2016-04-07 16:47:10', 763);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (959, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: edi
:by_id: 39
:comment_id: 211
:comment_name: "Ticket #60"
:ticket_id: 60
:ticket_summary: Report#54002220(Order_Entry_Batch_Update)
', 'f', '2016-04-07 16:47:10', '2016-04-07 16:47:10', 764);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (960, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: edi
:by_id: 39
:comment_id: 211
:comment_name: "Ticket #60"
:ticket_id: 60
:ticket_summary: Report#54002220(Order_Entry_Batch_Update)
', 'f', '2016-04-07 16:47:10', '2016-04-07 16:47:10', 764);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (961, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: edi
:by_id: 39
:comment_id: 211
:comment_name: "Ticket #60"
:ticket_id: 60
:ticket_summary: Report#54002220(Order_Entry_Batch_Update)
', 'f', '2016-04-07 16:47:10', '2016-04-07 16:47:10', 764);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (962, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: edi
:by_id: 39
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#54002220(Order_Entry_Batch_Update)
:ticket_id: 60
', 'f', '2016-04-07 16:47:11', '2016-04-07 16:47:11', 765);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (963, 'ticket_comment_added', '--- 
:body: "Ok\xE2\x80\xA6can you close?\n\n\
  From: Kelsan Customer Service\n\
  Sent: Thursday, April 07, 2016 4:45 PM\n\
  To: Monty Kilburn <mkilburn@kelsan.biz>\n\
  Subject: [Ticket #58] Test for Sue - Spiceworks\n\n\
  Customer Service Help Desk\n\n |\n\n\
  Monty Kilburn,\n\n\
  Ticket #58 was closed on Apr 07, 2016 @ 04:44 pm.\n\n\
  With the comment:\n\n\
  Ticket closed: Got it.\n\n\
  TICKET #58\n\n\
  Summary: Test for Sue\n\n\
  Description:\n\n\
  Let me know if you get this\xE2\x80\xA6.\n\n\
  Monty Kilburn | Director of Marketing\n\n\
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914\n\n |\n\n\
  Ticket History\n\n\
  _______________________________"
:by: Monty K.
:by_id: 5
:comment_id: 212
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-07 16:48:10', '2016-04-07 16:48:10', 766);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (964, 'ticket_comment_added', '--- 
:body: "Ok\xE2\x80\xA6can you close?\n\n\
  From: Kelsan Customer Service\n\
  Sent: Thursday, April 07, 2016 4:45 PM\n\
  To: Monty Kilburn <mkilburn@kelsan.biz>\n\
  Subject: [Ticket #58] Test for Sue - Spiceworks\n\n\
  Customer Service Help Desk\n\n |\n\n\
  Monty Kilburn,\n\n\
  Ticket #58 was closed on Apr 07, 2016 @ 04:44 pm.\n\n\
  With the comment:\n\n\
  Ticket closed: Got it.\n\n\
  TICKET #58\n\n\
  Summary: Test for Sue\n\n\
  Description:\n\n\
  Let me know if you get this\xE2\x80\xA6.\n\n\
  Monty Kilburn | Director of Marketing\n\n\
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914\n\n |\n\n\
  Ticket History\n\n\
  _______________________________"
:by: Monty K.
:by_id: 5
:comment_id: 212
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-07 16:48:10', '2016-04-07 16:48:10', 766);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (965, 'ticket_reopened', '--- 
:assigned_to: Sue S.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-07 16:48:10', '2016-04-07 16:48:10', 767);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (966, 'ticket_comment_added', '--- 
:body: "Ok\xE2\x80\xA6can you close?\n\n\
  From: Kelsan Customer Service\n\
  Sent: Thursday, April 07, 2016 4:45 PM\n\
  To: Monty Kilburn <mkilburn@kelsan.biz>\n\
  Subject: [Ticket #58] Test for Sue - Spiceworks\n\n\
  Customer Service Help Desk\n\n |\n\n\
  Monty Kilburn,\n\n\
  Ticket #58 was closed on Apr 07, 2016 @ 04:44 pm.\n\n\
  With the comment:\n\n\
  Ticket closed: Got it.\n\n\
  TICKET #58\n\n\
  Summary: Test for Sue\n\n\
  Description:\n\n\
  Let me know if you get this\xE2\x80\xA6.\n\n\
  Monty Kilburn | Director of Marketing\n\n\
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914\n\n |\n\n\
  Ticket History\n\n\
  _______________________________"
:by: Monty K.
:by_id: 5
:comment_id: 212
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-07 16:48:10', '2016-04-07 16:48:10', 768);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (967, 'ticket_opened', '--- 
:assigned_to: Sue S.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-07 16:48:10', '2016-04-07 16:48:10', 769);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (968, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-07"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#54002220(Order_Entry_Batch_Update)
:ticket_id: 60
', 'f', '2016-04-07 16:49:33', '2016-04-07 16:49:33', 770);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (969, 'user_created', '--- 
:by: Monty K.
:by_id: 5
:source: :user
:user_email: djwilliams@kelsan.biz
:user_id: 40
', 'f', '2016-04-07 16:56:11', '2016-04-07 16:56:11', 771);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (970, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: no-reply
:by_id: 37
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#583]
:ticket_id: 61
', 'f', '2016-04-08 01:30:12', '2016-04-08 01:30:12', 772);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (971, 'user_created', '--- 
:source: :user
:user_email: mailer-daemon@s12p02o143.mxlogic.net
:user_id: 41
', 'f', '2016-04-08 05:34:11', '2016-04-08 05:34:11', 773);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (972, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: mailer-daemon
:by_id: 41
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o143.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 62
', 'f', '2016-04-08 05:34:11', '2016-04-08 05:34:11', 774);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (973, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o143.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 62
', 'f', '2016-04-08 08:51:14', '2016-04-08 08:51:14', 775);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (974, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 214
:comment_name: "Ticket #62"
:ticket_id: 62
:ticket_summary: "Warning: could not send message for past 4 hours"
', 'f', '2016-04-08 08:56:57', '2016-04-08 08:56:57', 776);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (975, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o143.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 62
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-04-08 08:56:57', '2016-04-08 08:56:57', 777);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (976, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 214
:comment_name: "Ticket #62"
:ticket_id: 62
:ticket_summary: "Warning: could not send message for past 4 hours"
', 'f', '2016-04-08 08:56:57', '2016-04-08 08:56:57', 778);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (977, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o143.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 62
', 'f', '2016-04-08 08:56:57', '2016-04-08 08:56:57', 779);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (978, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 215
:comment_name: "Ticket #61"
:ticket_id: 61
:ticket_summary: Connect With Us [#583]
', 'f', '2016-04-08 08:57:17', '2016-04-08 08:57:17', 780);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (979, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#583]
:ticket_id: 61
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-04-08 08:57:18', '2016-04-08 08:57:18', 781);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (980, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Elizabeth H.
:by_id: 9
:comment_id: 215
:comment_name: "Ticket #61"
:ticket_id: 61
:ticket_summary: Connect With Us [#583]
', 'f', '2016-04-08 08:57:18', '2016-04-08 08:57:18', 782);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (981, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - 
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#583]
:ticket_id: 61
', 'f', '2016-04-08 08:57:18', '2016-04-08 08:57:18', 783);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (982, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - Unspecified
  - Customer Service
  first_sub_cat: 
  - Unspecified
  - Customer Service
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o143.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 62
', 'f', '2016-04-08 08:58:09', '2016-04-08 08:58:09', 783);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (983, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - Customer Service
  - Marketing
  first_sub_cat: 
  - Customer Service
  - Marketing
  second_sub_cat: 
  - 
  - Other
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o143.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 62
', 'f', '2016-04-08 08:58:41', '2016-04-08 08:58:41', 783);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (984, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o143.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 62
', 'f', '2016-04-08 08:58:45', '2016-04-08 08:58:45', 783);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (985, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Elizabeth H.
:by_id: 9
:comment_id: 216
:comment_name: "Ticket #62"
:ticket_id: 62
:ticket_summary: "Warning: could not send message for past 4 hours"
', 'f', '2016-04-08 08:59:09', '2016-04-08 08:59:09', 784);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (986, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o143.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 62
:to: Monty K.
:to_id: 5
', 'f', '2016-04-08 08:59:09', '2016-04-08 08:59:09', 785);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (987, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Elizabeth H.
:by_id: 9
:comment_id: 216
:comment_name: "Ticket #62"
:ticket_id: 62
:ticket_summary: "Warning: could not send message for past 4 hours"
', 'f', '2016-04-08 08:59:09', '2016-04-08 08:59:09', 786);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (988, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o143.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 62
', 'f', '2016-04-08 08:59:09', '2016-04-08 08:59:09', 787);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (989, 'ticket_comment_added', '--- 
:body: This is a response to our auto-response.
:by: Elizabeth H.
:by_id: 9
:comment_id: 217
:comment_name: "Ticket #62"
:ticket_id: 62
:ticket_summary: "Warning: could not send message for past 4 hours"
', 'f', '2016-04-08 08:59:29', '2016-04-08 08:59:29', 788);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (990, 'ticket_comment_added', '--- 
:body: This is a response to our auto-response.
:by: Elizabeth H.
:by_id: 9
:comment_id: 217
:comment_name: "Ticket #62"
:ticket_id: 62
:ticket_summary: "Warning: could not send message for past 4 hours"
', 'f', '2016-04-08 08:59:30', '2016-04-08 08:59:30', 788);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (991, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 63
', 'f', '2016-04-08 09:17:32', '2016-04-08 09:17:32', 789);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (992, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #63: test) added"
:by: Monty K.
:by_id: 5
:comment_id: 218
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 09:17:32', '2016-04-08 09:17:32', 790);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (993, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #63: test) added"
:by: Monty K.
:by_id: 5
:comment_id: 218
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 09:17:32', '2016-04-08 09:17:32', 790);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (994, 'ticket_comment_added', '--- 
:body: Trying to determine how to get this to Deonna.
:by: Elizabeth H.
:by_id: 9
:comment_id: 219
:comment_name: "Ticket #61"
:ticket_id: 61
:ticket_summary: Connect With Us [#583]
', 'f', '2016-04-08 09:18:11', '2016-04-08 09:18:11', 790);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (995, 'ticket_comment_added', '--- 
:body: Trying to determine how to get this to Deonna.
:by: Elizabeth H.
:by_id: 9
:comment_id: 219
:comment_name: "Ticket #61"
:ticket_id: 61
:ticket_summary: Connect With Us [#583]
', 'f', '2016-04-08 09:18:11', '2016-04-08 09:18:11', 790);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (996, 'user_created', '--- 
:by: Reymund E.
:by_id: 20
:source: :user
:user_email: dstarkey@kelsan.biz
:user_id: 42
', 'f', '2016-04-08 09:24:51', '2016-04-08 09:24:51', 791);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (997, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 220
:comment_name: "Ticket #64"
:ticket_id: 64
:ticket_summary: Where''s my order
', 'f', '2016-04-08 09:27:10', '2016-04-08 09:27:10', 792);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (998, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Monty K.
:by_id: 5
:comment_id: 220
:comment_name: "Ticket #64"
:ticket_id: 64
:ticket_summary: Where''s my order
', 'f', '2016-04-08 09:27:11', '2016-04-08 09:27:11', 792);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (999, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Where''s my order
:ticket_id: 64
', 'f', '2016-04-08 09:27:11', '2016-04-08 09:27:11', 793);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1000, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 221
:comment_name: "Ticket #64"
:ticket_id: 64
:ticket_summary: Where''s my order
', 'f', '2016-04-08 09:27:18', '2016-04-08 09:27:18', 794);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1001, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Where''s my order
:ticket_id: 64
:to: Monty K.
:to_id: 5
', 'f', '2016-04-08 09:27:18', '2016-04-08 09:27:18', 795);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1002, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 221
:comment_name: "Ticket #64"
:ticket_id: 64
:ticket_summary: Where''s my order
', 'f', '2016-04-08 09:27:18', '2016-04-08 09:27:18', 796);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1003, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - 
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Where''s my order
:ticket_id: 64
', 'f', '2016-04-08 09:27:18', '2016-04-08 09:27:18', 797);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1004, 'ticket_comment_added', '--- 
:body: Assigned to Jade Johnston.
:by: Monty K.
:by_id: 5
:comment_id: 222
:comment_name: "Ticket #65"
:ticket_id: 65
:ticket_summary: Customer needs information on delivery
', 'f', '2016-04-08 09:28:04', '2016-04-08 09:28:04', 798);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1005, 'ticket_reassigned', '--- 
:assigned_to: Jade J.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Customer needs information on delivery
:ticket_id: 65
:to: Jade J.
:to_id: 26
', 'f', '2016-04-08 09:28:04', '2016-04-08 09:28:04', 799);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1006, 'ticket_comment_added', '--- 
:body: Assigned to Jade Johnston.
:by: Monty K.
:by_id: 5
:comment_id: 222
:comment_name: "Ticket #65"
:ticket_id: 65
:ticket_summary: Customer needs information on delivery
', 'f', '2016-04-08 09:28:04', '2016-04-08 09:28:04', 800);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1007, 'ticket_opened', '--- 
:assigned_to: Jade J.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Customer needs information on delivery
:ticket_id: 65
', 'f', '2016-04-08 09:28:05', '2016-04-08 09:28:05', 801);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1008, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #65: Customer needs information on delivery) added"
:by: Monty K.
:by_id: 5
:comment_id: 223
:comment_name: "Ticket #64"
:ticket_id: 64
:ticket_summary: Where''s my order
', 'f', '2016-04-08 09:28:05', '2016-04-08 09:28:05', 802);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1009, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #65: Customer needs information on delivery) added"
:by: Monty K.
:by_id: 5
:comment_id: 223
:comment_name: "Ticket #64"
:ticket_id: 64
:ticket_summary: Where''s my order
', 'f', '2016-04-08 09:28:05', '2016-04-08 09:28:05', 802);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1010, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #65: Customer needs information on delivery) closed"
:by: Monty K.
:by_id: 5
:comment_id: 224
:comment_name: "Ticket #64"
:ticket_id: 64
:ticket_summary: Where''s my order
', 'f', '2016-04-08 09:28:18', '2016-04-08 09:28:18', 802);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1011, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #65: Customer needs information on delivery) closed"
:by: Monty K.
:by_id: 5
:comment_id: 224
:comment_name: "Ticket #64"
:ticket_id: 64
:ticket_summary: Where''s my order
', 'f', '2016-04-08 09:28:18', '2016-04-08 09:28:18', 802);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1012, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 225
:comment_name: "Ticket #65"
:ticket_id: 65
:ticket_summary: Customer needs information on delivery
', 'f', '2016-04-08 09:28:18', '2016-04-08 09:28:18', 802);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1013, 'ticket_closed', '--- 
:assigned_to: Jade J.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Customer needs information on delivery
:ticket_id: 65
', 'f', '2016-04-08 09:28:18', '2016-04-08 09:28:18', 803);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1014, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 225
:comment_name: "Ticket #65"
:ticket_id: 65
:ticket_summary: Customer needs information on delivery
', 'f', '2016-04-08 09:28:18', '2016-04-08 09:28:18', 804);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1015, 'ticket_updated', '--- 
:assigned_to: Jade J.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - 
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Customer needs information on delivery
:ticket_id: 65
', 'f', '2016-04-08 09:28:18', '2016-04-08 09:28:18', 805);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1016, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 226
:comment_name: "Ticket #64"
:ticket_id: 64
:ticket_summary: Where''s my order
', 'f', '2016-04-08 09:28:29', '2016-04-08 09:28:29', 806);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1017, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Where''s my order
:ticket_id: 64
', 'f', '2016-04-08 09:28:29', '2016-04-08 09:28:29', 807);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1018, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 226
:comment_name: "Ticket #64"
:ticket_id: 64
:ticket_summary: Where''s my order
', 'f', '2016-04-08 09:28:29', '2016-04-08 09:28:29', 808);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1019, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Where''s my order
:ticket_id: 64
', 'f', '2016-04-08 09:28:29', '2016-04-08 09:28:29', 809);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1020, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Sue S.
:by_id: 8
:changes: 
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#54002220(Order_Entry_Batch_Update)
:ticket_id: 60
', 'f', '2016-04-08 09:28:52', '2016-04-08 09:28:52', 809);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1021, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 227
:comment_name: "Ticket #63"
:ticket_id: 63
:ticket_summary: test
', 'f', '2016-04-08 09:29:25', '2016-04-08 09:29:25', 810);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1022, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 63
:to: Monty K.
:to_id: 5
', 'f', '2016-04-08 09:29:25', '2016-04-08 09:29:25', 811);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1023, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 227
:comment_name: "Ticket #63"
:ticket_id: 63
:ticket_summary: test
', 'f', '2016-04-08 09:29:25', '2016-04-08 09:29:25', 812);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1024, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - 
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 63
', 'f', '2016-04-08 09:29:25', '2016-04-08 09:29:25', 813);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1025, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #63: test) closed"
:by: Monty K.
:by_id: 5
:comment_id: 228
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 09:29:27', '2016-04-08 09:29:27', 814);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1026, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #63: test) closed"
:by: Monty K.
:by_id: 5
:comment_id: 228
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 09:29:27', '2016-04-08 09:29:27', 814);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1027, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 229
:comment_name: "Ticket #63"
:ticket_id: 63
:ticket_summary: test
', 'f', '2016-04-08 09:29:27', '2016-04-08 09:29:27', 814);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1028, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 63
', 'f', '2016-04-08 09:29:27', '2016-04-08 09:29:27', 815);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1029, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 229
:comment_name: "Ticket #63"
:ticket_id: 63
:ticket_summary: test
', 'f', '2016-04-08 09:29:27', '2016-04-08 09:29:27', 816);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1030, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 63
', 'f', '2016-04-08 09:29:27', '2016-04-08 09:29:27', 817);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1031, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 230
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 09:29:32', '2016-04-08 09:29:32', 818);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1032, 'ticket_closed', '--- 
:assigned_to: Sue S.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-08 09:29:32', '2016-04-08 09:29:32', 819);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1033, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 230
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 09:29:32', '2016-04-08 09:29:32', 820);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1034, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-08 09:29:32', '2016-04-08 09:29:32', 821);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1035, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#583]
:ticket_id: 61
', 'f', '2016-04-08 09:33:39', '2016-04-08 09:33:39', 821);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1036, 'ticket_comment_added', '--- 
:body: Deonna - Sending this e-mail request your way for contact.  Hopefully this method works!
:by: Elizabeth H.
:by_id: 9
:comment_id: 231
:comment_name: "Ticket #61"
:ticket_id: 61
:ticket_summary: Connect With Us [#583]
', 'f', '2016-04-08 09:35:24', '2016-04-08 09:35:24', 822);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1037, 'ticket_comment_added', '--- 
:body: Deonna - Sending this e-mail request your way for contact.  Hopefully this method works!
:by: Elizabeth H.
:by_id: 9
:comment_id: 231
:comment_name: "Ticket #61"
:ticket_id: 61
:ticket_summary: Connect With Us [#583]
', 'f', '2016-04-08 09:35:24', '2016-04-08 09:35:24', 822);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1038, 'ticket_comment_added', '--- 
:body: "Received.\n\n\
  Sue Stapleton | Customer Service Manager\n\n\
  P 865.525.7132, extn. 268 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914\n\n\
  From: Kelsan Customer Service\n\
  Sent: Friday, April 08, 2016 9:30 AM\n\
  To: Sue Stapleton\n\
  Subject: [Ticket #58] Test for Sue - Spiceworks\n\n\
  Customer Service Help Desk\n\n |\n\n\
  Sue Stapleton,\n\n\
  Ticket #58 was closed on Apr 08, 2016 @ 09:29 am.\n\n\
  With the comment:\n\n\
  Ticket closed.\n\n\
  TICKET #58\n\n\
  Summary: Test for Sue\n\n\
  Description:\n\n\
  Let me know if you get this\xE2\x80\xA6.\n\n\
  Monty Kilburn | Director of Marketing\n\n\
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914\n\n |\n\n\
  Ticket History\n\n\
  _______________________________"
:by: Sue S.
:by_id: 8
:comment_id: 232
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 09:55:10', '2016-04-08 09:55:10', 822);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1039, 'ticket_comment_added', '--- 
:body: "Received.\n\n\
  Sue Stapleton | Customer Service Manager\n\n\
  P 865.525.7132, extn. 268 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914\n\n\
  From: Kelsan Customer Service\n\
  Sent: Friday, April 08, 2016 9:30 AM\n\
  To: Sue Stapleton\n\
  Subject: [Ticket #58] Test for Sue - Spiceworks\n\n\
  Customer Service Help Desk\n\n |\n\n\
  Sue Stapleton,\n\n\
  Ticket #58 was closed on Apr 08, 2016 @ 09:29 am.\n\n\
  With the comment:\n\n\
  Ticket closed.\n\n\
  TICKET #58\n\n\
  Summary: Test for Sue\n\n\
  Description:\n\n\
  Let me know if you get this\xE2\x80\xA6.\n\n\
  Monty Kilburn | Director of Marketing\n\n\
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914\n\n |\n\n\
  Ticket History\n\n\
  _______________________________"
:by: Sue S.
:by_id: 8
:comment_id: 232
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 09:55:10', '2016-04-08 09:55:10', 822);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1040, 'ticket_comment_added', '--- 
:body: "Received.\n\n\
  Sue Stapleton | Customer Service Manager\n\n\
  P 865.525.7132, extn. 268 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914\n\n\
  From: Kelsan Customer Service\n\
  Sent: Friday, April 08, 2016 9:30 AM\n\
  To: Sue Stapleton\n\
  Subject: [Ticket #58] Test for Sue - Spiceworks\n\n\
  Customer Service Help Desk\n\n |\n\n\
  Sue Stapleton,\n\n\
  Ticket #58 was closed on Apr 08, 2016 @ 09:29 am.\n\n\
  With the comment:\n\n\
  Ticket closed.\n\n\
  TICKET #58\n\n\
  Summary: Test for Sue\n\n\
  Description:\n\n\
  Let me know if you get this\xE2\x80\xA6.\n\n\
  Monty Kilburn | Director of Marketing\n\n\
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914\n\n |\n\n\
  Ticket History\n\n\
  _______________________________"
:by: Sue S.
:by_id: 8
:comment_id: 232
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 09:55:10', '2016-04-08 09:55:10', 822);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1041, 'ticket_reopened', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:email: sstapleton@kelsan.biz
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-08 09:55:10', '2016-04-08 09:55:10', 823);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1042, 'ticket_comment_added', '--- 
:body: "Received.\n\n\
  Sue Stapleton | Customer Service Manager\n\n\
  P 865.525.7132, extn. 268 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914\n\n\
  From: Kelsan Customer Service\n\
  Sent: Friday, April 08, 2016 9:30 AM\n\
  To: Sue Stapleton\n\
  Subject: [Ticket #58] Test for Sue - Spiceworks\n\n\
  Customer Service Help Desk\n\n |\n\n\
  Sue Stapleton,\n\n\
  Ticket #58 was closed on Apr 08, 2016 @ 09:29 am.\n\n\
  With the comment:\n\n\
  Ticket closed.\n\n\
  TICKET #58\n\n\
  Summary: Test for Sue\n\n\
  Description:\n\n\
  Let me know if you get this\xE2\x80\xA6.\n\n\
  Monty Kilburn | Director of Marketing\n\n\
  P 865.684.2597 | C 865.599.2361 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914\n\n |\n\n\
  Ticket History\n\n\
  _______________________________"
:by: Sue S.
:by_id: 8
:comment_id: 232
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 09:55:10', '2016-04-08 09:55:10', 824);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1043, 'ticket_opened', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-08 09:55:10', '2016-04-08 09:55:10', 825);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1044, 'ticket_comment_added', '--- 
:body: |-
  Received.
  
  Sue Stapleton | Customer Service Manager
  
  P 865.525.7132, extn. 268 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
  
  From: Kelsan Customer Service
  Sent: Friday, April 08, 2016 9:30 AM
  To: Sue Stapleton
  Subject: [Ticket #58] Test for Sue - Spiceworks
  
  Customer Service Help Desk
  
   |
  
  Sue Stapleton,
:by: Sue S.
:by_id: 8
:comment_id: 235
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 09:55:11', '2016-04-08 09:55:11', 826);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1045, 'ticket_comment_added', '--- 
:body: |-
  Received.
  
  Sue Stapleton | Customer Service Manager
  
  P 865.525.7132, extn. 268 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
  
  From: Kelsan Customer Service
  Sent: Friday, April 08, 2016 9:30 AM
  To: Sue Stapleton
  Subject: [Ticket #58] Test for Sue - Spiceworks
  
  Customer Service Help Desk
  
   |
  
  Sue Stapleton,
:by: Sue S.
:by_id: 8
:comment_id: 235
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 09:55:11', '2016-04-08 09:55:11', 826);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1046, 'ticket_comment_added', '--- 
:body: |-
  Received.
  
  Sue Stapleton | Customer Service Manager
  
  P 865.525.7132, extn. 268 | F 865.637.5053 | 5109 National Drive, Knoxville, TN 37914
  
  From: Kelsan Customer Service
  Sent: Friday, April 08, 2016 9:30 AM
  To: Sue Stapleton
  Subject: [Ticket #58] Test for Sue - Spiceworks
  
  Customer Service Help Desk
  
   |
  
  Sue Stapleton,
:by: Sue S.
:by_id: 8
:comment_id: 235
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 09:55:11', '2016-04-08 09:55:11', 826);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1047, 'ticket_opened', '--- 
:assigned_to: Sue S.
:by: Sue S.
:by_id: 8
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-08 09:55:11', '2016-04-08 09:55:11', 827);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1048, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - Customer Service
  - ""
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-08 10:36:47', '2016-04-08 10:36:47', 828);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1049, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 237
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 10:38:37', '2016-04-08 10:38:37', 829);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1050, 'ticket_closed', '--- 
:assigned_to: Sue S.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-08 10:38:37', '2016-04-08 10:38:37', 830);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1051, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 237
:comment_name: "Ticket #58"
:ticket_id: 58
:ticket_summary: Test for Sue
', 'f', '2016-04-08 10:38:37', '2016-04-08 10:38:37', 831);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1052, 'ticket_updated', '--- 
:assigned_to: Sue S.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: Test for Sue
:ticket_id: 58
', 'f', '2016-04-08 10:38:37', '2016-04-08 10:38:37', 832);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1053, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 238
:comment_name: "Ticket #60"
:ticket_id: 60
:ticket_summary: Report#54002220(Order_Entry_Batch_Update)
', 'f', '2016-04-08 10:38:55', '2016-04-08 10:38:55', 833);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1054, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#54002220(Order_Entry_Batch_Update)
:ticket_id: 60
:to: Monty K.
:to_id: 5
', 'f', '2016-04-08 10:38:55', '2016-04-08 10:38:55', 834);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1055, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 238
:comment_name: "Ticket #60"
:ticket_id: 60
:ticket_summary: Report#54002220(Order_Entry_Batch_Update)
', 'f', '2016-04-08 10:38:55', '2016-04-08 10:38:55', 835);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1056, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#54002220(Order_Entry_Batch_Update)
:ticket_id: 60
', 'f', '2016-04-08 10:38:55', '2016-04-08 10:38:55', 836);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1057, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 66
', 'f', '2016-04-08 10:39:50', '2016-04-08 10:39:50', 837);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1058, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #66: test) added"
:by: Monty K.
:by_id: 5
:comment_id: 239
:comment_name: "Ticket #60"
:ticket_id: 60
:ticket_summary: Report#54002220(Order_Entry_Batch_Update)
', 'f', '2016-04-08 10:39:50', '2016-04-08 10:39:50', 838);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1059, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #66: test) added"
:by: Monty K.
:by_id: 5
:comment_id: 239
:comment_name: "Ticket #60"
:ticket_id: 60
:ticket_summary: Report#54002220(Order_Entry_Batch_Update)
', 'f', '2016-04-08 10:39:50', '2016-04-08 10:39:50', 838);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1060, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Ryan H.
:by_id: 6
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: ryan.heintz@ballistix.com
:summary: BALLISTIX TEST
:ticket_id: 67
', 'f', '2016-04-08 10:47:10', '2016-04-08 10:47:10', 839);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1061, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 240
:comment_name: "Ticket #67"
:ticket_id: 67
:ticket_summary: BALLISTIX TEST
', 'f', '2016-04-08 10:47:24', '2016-04-08 10:47:24', 840);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1062, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: ryan.heintz@ballistix.com
:summary: BALLISTIX TEST
:ticket_id: 67
:to: Monty K.
:to_id: 5
', 'f', '2016-04-08 10:47:24', '2016-04-08 10:47:24', 841);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1063, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 240
:comment_name: "Ticket #67"
:ticket_id: 67
:ticket_summary: BALLISTIX TEST
', 'f', '2016-04-08 10:47:24', '2016-04-08 10:47:24', 842);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1064, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - 
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: ryan.heintz@ballistix.com
:summary: BALLISTIX TEST
:ticket_id: 67
', 'f', '2016-04-08 10:47:24', '2016-04-08 10:47:24', 843);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1065, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Customer Service
  first_sub_cat: 
  - 
  - Customer Service
  second_sub_cat: 
  - 
  - Other
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: ryan.heintz@ballistix.com
:summary: BALLISTIX TEST
:ticket_id: 67
', 'f', '2016-04-08 10:47:31', '2016-04-08 10:47:31', 843);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1066, 'ticket_comment_added', '--- 
:body: hi ryan!!
:by: Monty K.
:by_id: 5
:comment_id: 241
:comment_name: "Ticket #67"
:ticket_id: 67
:ticket_summary: BALLISTIX TEST
', 'f', '2016-04-08 10:47:54', '2016-04-08 10:47:54', 844);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1067, 'ticket_comment_added', '--- 
:body: hi ryan!!
:by: Monty K.
:by_id: 5
:comment_id: 241
:comment_name: "Ticket #67"
:ticket_id: 67
:ticket_summary: BALLISTIX TEST
', 'f', '2016-04-08 10:47:54', '2016-04-08 10:47:54', 844);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1068, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 242
:comment_name: "Ticket #67"
:ticket_id: 67
:ticket_summary: BALLISTIX TEST
', 'f', '2016-04-08 10:47:58', '2016-04-08 10:47:58', 844);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1069, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: ryan.heintz@ballistix.com
:summary: BALLISTIX TEST
:ticket_id: 67
', 'f', '2016-04-08 10:47:58', '2016-04-08 10:47:58', 845);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1070, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 242
:comment_name: "Ticket #67"
:ticket_id: 67
:ticket_summary: BALLISTIX TEST
', 'f', '2016-04-08 10:47:58', '2016-04-08 10:47:58', 846);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1071, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: ryan.heintz@ballistix.com
:summary: BALLISTIX TEST
:ticket_id: 67
', 'f', '2016-04-08 10:47:58', '2016-04-08 10:47:58', 847);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1072, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 243
:comment_name: "Ticket #62"
:ticket_id: 62
:ticket_summary: "Warning: could not send message for past 4 hours"
', 'f', '2016-04-08 10:54:59', '2016-04-08 10:54:59', 848);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1073, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o143.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 62
', 'f', '2016-04-08 10:54:59', '2016-04-08 10:54:59', 849);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1074, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 243
:comment_name: "Ticket #62"
:ticket_id: 62
:ticket_summary: "Warning: could not send message for past 4 hours"
', 'f', '2016-04-08 10:54:59', '2016-04-08 10:54:59', 850);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1075, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - Unspecified
  - Accounting
  first_sub_cat: 
  - Unspecified
  - Accounting
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#583]
:ticket_id: 61
', 'f', '2016-04-08 10:59:01', '2016-04-08 10:59:01', 851);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1076, 'ticket_comment_added', '--- 
:body: Listed Deonna to cc, but she didn''t receive it.  Copied and pasted and sent to her.   Leaving this open in case somebody wants to do additional testing.
:by: Elizabeth H.
:by_id: 9
:comment_id: 244
:comment_name: "Ticket #61"
:ticket_id: 61
:ticket_summary: Connect With Us [#583]
', 'f', '2016-04-08 11:03:07', '2016-04-08 11:03:07', 852);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1077, 'ticket_comment_added', '--- 
:body: Listed Deonna to cc, but she didn''t receive it.  Copied and pasted and sent to her.   Leaving this open in case somebody wants to do additional testing.
:by: Elizabeth H.
:by_id: 9
:comment_id: 244
:comment_name: "Ticket #61"
:ticket_id: 61
:ticket_summary: Connect With Us [#583]
', 'f', '2016-04-08 11:03:07', '2016-04-08 11:03:07', 852);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1078, 'ticket_comment_added', '--- 
:body: "Ticket closed: Per Monty: I think IT is working on the notifications, so they may not be functional today.  I am will add other support people not in Knoxville to the system next week after we get all the details ironed out."
:by: Elizabeth H.
:by_id: 9
:comment_id: 245
:comment_name: "Ticket #61"
:ticket_id: 61
:ticket_summary: Connect With Us [#583]
', 'f', '2016-04-08 11:03:43', '2016-04-08 11:03:43', 852);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1079, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:email: eheaton@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#583]
:ticket_id: 61
', 'f', '2016-04-08 11:03:43', '2016-04-08 11:03:43', 853);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1080, 'ticket_comment_added', '--- 
:body: "Ticket closed: Per Monty: I think IT is working on the notifications, so they may not be functional today.  I am will add other support people not in Knoxville to the system next week after we get all the details ironed out."
:by: Elizabeth H.
:by_id: 9
:comment_id: 245
:comment_name: "Ticket #61"
:ticket_id: 61
:ticket_summary: Connect With Us [#583]
', 'f', '2016-04-08 11:03:44', '2016-04-08 11:03:44', 854);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1081, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Eddina W.
:by_id: 40
:comment_id: 246
:comment_name: "Ticket #68"
:ticket_id: 68
:ticket_summary: test
', 'f', '2016-04-08 11:58:11', '2016-04-08 11:58:11', 854);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1082, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Eddina W.
:by_id: 40
:comment_id: 246
:comment_name: "Ticket #68"
:ticket_id: 68
:ticket_summary: test
', 'f', '2016-04-08 11:58:11', '2016-04-08 11:58:11', 854);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1083, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Eddina W.
:by_id: 40
:comment_id: 246
:comment_name: "Ticket #68"
:ticket_id: 68
:ticket_summary: test
', 'f', '2016-04-08 11:58:11', '2016-04-08 11:58:11', 854);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1084, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: Eddina W.
:by_id: 40
:comment_id: 246
:comment_name: "Ticket #68"
:ticket_id: 68
:ticket_summary: test
', 'f', '2016-04-08 11:58:11', '2016-04-08 11:58:11', 854);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1085, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: djwilliams@kelsan.biz
:summary: test
:ticket_id: 68
', 'f', '2016-04-08 11:58:12', '2016-04-08 11:58:12', 855);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1086, 'ticket_comment_added', '--- 
:body: Assigned to Eddina Williams.
:by: Eddina W.
:by_id: 40
:comment_id: 248
:comment_name: "Ticket #68"
:ticket_id: 68
:ticket_summary: test
', 'f', '2016-04-08 11:58:21', '2016-04-08 11:58:21', 856);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1087, 'ticket_reassigned', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: djwilliams@kelsan.biz
:summary: test
:ticket_id: 68
:to: Eddina W.
:to_id: 40
', 'f', '2016-04-08 11:58:21', '2016-04-08 11:58:21', 857);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1088, 'ticket_comment_added', '--- 
:body: Assigned to Eddina Williams.
:by: Eddina W.
:by_id: 40
:comment_id: 248
:comment_name: "Ticket #68"
:ticket_id: 68
:ticket_summary: test
', 'f', '2016-04-08 11:58:21', '2016-04-08 11:58:21', 858);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1089, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:changes: 
  status_updated_at: 
  - 
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: djwilliams@kelsan.biz
:summary: test
:ticket_id: 68
', 'f', '2016-04-08 11:58:21', '2016-04-08 11:58:21', 859);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1090, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:changes: 
  category: 
  - 
  - Customer Service
  first_sub_cat: 
  - 
  - Customer Service
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: djwilliams@kelsan.biz
:summary: test
:ticket_id: 68
', 'f', '2016-04-08 11:58:28', '2016-04-08 11:58:28', 859);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1091, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:changes: 
  second_sub_cat: 
  - 
  - Program Account
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: djwilliams@kelsan.biz
:summary: test
:ticket_id: 68
', 'f', '2016-04-08 11:58:34', '2016-04-08 11:58:34', 859);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1092, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Eddina W.
:by_id: 40
:comment_id: 249
:comment_name: "Ticket #68"
:ticket_id: 68
:ticket_summary: test
', 'f', '2016-04-08 11:58:39', '2016-04-08 11:58:39', 860);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1093, 'ticket_closed', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:email: djwilliams@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: djwilliams@kelsan.biz
:summary: test
:ticket_id: 68
', 'f', '2016-04-08 11:58:39', '2016-04-08 11:58:39', 861);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1094, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Eddina W.
:by_id: 40
:comment_id: 249
:comment_name: "Ticket #68"
:ticket_id: 68
:ticket_summary: test
', 'f', '2016-04-08 11:58:39', '2016-04-08 11:58:39', 862);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1095, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: djwilliams@kelsan.biz
:summary: test
:ticket_id: 68
', 'f', '2016-04-08 11:58:39', '2016-04-08 11:58:39', 863);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1096, 'ticket_comment_added', '--- 
:body: Assigned to Eddina Williams.
:by: Eddina W.
:by_id: 40
:comment_id: 250
:comment_name: "Ticket #66"
:ticket_id: 66
:ticket_summary: test
', 'f', '2016-04-08 12:00:49', '2016-04-08 12:00:49', 864);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1097, 'ticket_reassigned', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 66
:to: Eddina W.
:to_id: 40
', 'f', '2016-04-08 12:00:49', '2016-04-08 12:00:49', 865);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1098, 'ticket_comment_added', '--- 
:body: Assigned to Eddina Williams.
:by: Eddina W.
:by_id: 40
:comment_id: 250
:comment_name: "Ticket #66"
:ticket_id: 66
:ticket_summary: test
', 'f', '2016-04-08 12:00:49', '2016-04-08 12:00:49', 866);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1099, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:changes: 
  status_updated_at: 
  - 
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 66
', 'f', '2016-04-08 12:00:49', '2016-04-08 12:00:49', 867);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1100, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #66: test) closed"
:by: Eddina W.
:by_id: 40
:comment_id: 251
:comment_name: "Ticket #60"
:ticket_id: 60
:ticket_summary: Report#54002220(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:00:59', '2016-04-08 12:00:59', 868);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1101, 'ticket_comment_added', '--- 
:body: "Subticket (Ticket #66: test) closed"
:by: Eddina W.
:by_id: 40
:comment_id: 251
:comment_name: "Ticket #60"
:ticket_id: 60
:ticket_summary: Report#54002220(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:00:59', '2016-04-08 12:00:59', 868);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1102, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Eddina W.
:by_id: 40
:comment_id: 252
:comment_name: "Ticket #66"
:ticket_id: 66
:ticket_summary: test
', 'f', '2016-04-08 12:01:00', '2016-04-08 12:01:00', 868);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1103, 'ticket_closed', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:email: djwilliams@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 66
', 'f', '2016-04-08 12:01:00', '2016-04-08 12:01:00', 869);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1104, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Eddina W.
:by_id: 40
:comment_id: 252
:comment_name: "Ticket #66"
:ticket_id: 66
:ticket_summary: test
', 'f', '2016-04-08 12:01:00', '2016-04-08 12:01:00', 870);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1105, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: mkilburn@kelsan.biz
:summary: test
:ticket_id: 66
', 'f', '2016-04-08 12:01:00', '2016-04-08 12:01:00', 871);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1106, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Eddina W.
:by_id: 40
:comment_id: 253
:comment_name: "Ticket #60"
:ticket_id: 60
:ticket_summary: Report#54002220(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:01:12', '2016-04-08 12:01:12', 872);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1107, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:email: djwilliams@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#54002220(Order_Entry_Batch_Update)
:ticket_id: 60
', 'f', '2016-04-08 12:01:12', '2016-04-08 12:01:12', 873);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1108, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Eddina W.
:by_id: 40
:comment_id: 253
:comment_name: "Ticket #60"
:ticket_id: 60
:ticket_summary: Report#54002220(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:01:12', '2016-04-08 12:01:12', 874);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1109, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Eddina W.
:by_id: 40
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#54002220(Order_Entry_Batch_Update)
:ticket_id: 60
', 'f', '2016-04-08 12:01:12', '2016-04-08 12:01:12', 875);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1110, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: edi
:by_id: 39
:comment_id: 254
:comment_name: "Ticket #69"
:ticket_id: 69
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:08:10', '2016-04-08 12:08:10', 876);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1111, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: edi
:by_id: 39
:comment_id: 254
:comment_name: "Ticket #69"
:ticket_id: 69
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:08:10', '2016-04-08 12:08:10', 876);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1112, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: edi
:by_id: 39
:comment_id: 254
:comment_name: "Ticket #69"
:ticket_id: 69
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:08:10', '2016-04-08 12:08:10', 876);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1113, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: edi
:by_id: 39
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 69
', 'f', '2016-04-08 12:08:11', '2016-04-08 12:08:11', 877);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1114, 'ticket_comment_added', '--- 
:body: Assigned to Eddina Williams.
:by: Eddina W.
:by_id: 40
:comment_id: 255
:comment_name: "Ticket #69"
:ticket_id: 69
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:10:14', '2016-04-08 12:10:14', 878);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1115, 'ticket_reassigned', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 69
:to: Eddina W.
:to_id: 40
', 'f', '2016-04-08 12:10:14', '2016-04-08 12:10:14', 879);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1116, 'ticket_comment_added', '--- 
:body: Assigned to Eddina Williams.
:by: Eddina W.
:by_id: 40
:comment_id: 255
:comment_name: "Ticket #69"
:ticket_id: 69
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:10:14', '2016-04-08 12:10:14', 880);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1117, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:changes: 
  status_updated_at: 
  - 
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 69
', 'f', '2016-04-08 12:10:14', '2016-04-08 12:10:14', 881);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1118, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:changes: 
  category: 
  - 
  - Customer Service
  first_sub_cat: 
  - 
  - Customer Service
  second_sub_cat: 
  - 
  - Program Account
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 69
', 'f', '2016-04-08 12:10:35', '2016-04-08 12:10:35', 881);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1119, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Eddina W.
:by_id: 40
:comment_id: 256
:comment_name: "Ticket #69"
:ticket_id: 69
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:11:19', '2016-04-08 12:11:19', 882);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1120, 'ticket_closed', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:email: djwilliams@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 69
', 'f', '2016-04-08 12:11:19', '2016-04-08 12:11:19', 883);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1121, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Eddina W.
:by_id: 40
:comment_id: 256
:comment_name: "Ticket #69"
:ticket_id: 69
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:11:19', '2016-04-08 12:11:19', 884);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1122, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 69
', 'f', '2016-04-08 12:11:19', '2016-04-08 12:11:19', 885);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1123, 'ticket_comment_added', '--- 
:body: Ticket re-opened.
:by: Eddina W.
:by_id: 40
:comment_id: 257
:comment_name: "Ticket #69"
:ticket_id: 69
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:11:22', '2016-04-08 12:11:22', 886);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1124, 'ticket_reopened', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:email: djwilliams@kelsan.biz
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 69
', 'f', '2016-04-08 12:11:23', '2016-04-08 12:11:23', 887);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1125, 'ticket_comment_added', '--- 
:body: Ticket re-opened.
:by: Eddina W.
:by_id: 40
:comment_id: 257
:comment_name: "Ticket #69"
:ticket_id: 69
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:11:23', '2016-04-08 12:11:23', 888);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1126, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:changes: 
  status: 
  - closed
  - open
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 69
', 'f', '2016-04-08 12:11:23', '2016-04-08 12:11:23', 889);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1127, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: edi
:by_id: 39
:comment_id: 258
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:12:10', '2016-04-08 12:12:10', 890);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1128, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: edi
:by_id: 39
:comment_id: 258
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:12:10', '2016-04-08 12:12:10', 890);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1129, 'ticket_comment_added', '--- 
:body: "Attachment:"
:by: edi
:by_id: 39
:comment_id: 258
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:12:11', '2016-04-08 12:12:11', 890);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1130, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: edi
:by_id: 39
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
', 'f', '2016-04-08 12:12:11', '2016-04-08 12:12:11', 891);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1131, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
', 'f', '2016-04-08 12:12:18', '2016-04-08 12:12:18', 892);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1132, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Eddina W.
:by_id: 40
:comment_id: 259
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:12:50', '2016-04-08 12:12:50', 893);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1133, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-04-08 12:12:50', '2016-04-08 12:12:50', 894);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1134, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Eddina W.
:by_id: 40
:comment_id: 259
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:12:50', '2016-04-08 12:12:50', 895);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1135, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Eddina W.
:by_id: 40
:changes: 
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
', 'f', '2016-04-08 12:12:50', '2016-04-08 12:12:50', 896);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1136, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Elizabeth H.
:by_id: 9
:changes: 
  category: 
  - Unspecified
  - Customer Service
  first_sub_cat: 
  - Unspecified
  - Customer Service
  second_sub_cat: 
  - 
  - Program Account
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
', 'f', '2016-04-08 12:12:53', '2016-04-08 12:12:53', 896);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1137, 'ticket_comment_added', '--- 
:body: Assigned to Eddina Williams.
:by: Elizabeth H.
:by_id: 9
:comment_id: 260
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:13:03', '2016-04-08 12:13:03', 897);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1138, 'ticket_reassigned', '--- 
:assigned_to: Eddina W.
:by: Elizabeth H.
:by_id: 9
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
:to: Eddina W.
:to_id: 40
', 'f', '2016-04-08 12:13:03', '2016-04-08 12:13:03', 898);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1139, 'ticket_comment_added', '--- 
:body: Assigned to Eddina Williams.
:by: Elizabeth H.
:by_id: 9
:comment_id: 260
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:13:03', '2016-04-08 12:13:03', 899);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1140, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Elizabeth H.
:by_id: 9
:changes: 
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
', 'f', '2016-04-08 12:13:04', '2016-04-08 12:13:04', 900);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1141, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Eddina W.
:by_id: 40
:comment_id: 261
:comment_name: "Ticket #69"
:ticket_id: 69
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:13:21', '2016-04-08 12:13:21', 901);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1142, 'ticket_closed', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:email: djwilliams@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 69
', 'f', '2016-04-08 12:13:21', '2016-04-08 12:13:21', 902);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1143, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Eddina W.
:by_id: 40
:comment_id: 261
:comment_name: "Ticket #69"
:ticket_id: 69
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:13:21', '2016-04-08 12:13:21', 903);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1144, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 69
', 'f', '2016-04-08 12:13:21', '2016-04-08 12:13:21', 904);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1145, 'ticket_comment_added', '--- 
:body: "Ticket closed: testing 123"
:by: Eddina W.
:by_id: 40
:comment_id: 262
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:17:15', '2016-04-08 12:17:15', 905);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1146, 'ticket_closed', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:email: djwilliams@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
', 'f', '2016-04-08 12:17:15', '2016-04-08 12:17:15', 906);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1147, 'ticket_comment_added', '--- 
:body: "Ticket closed: testing 123"
:by: Eddina W.
:by_id: 40
:comment_id: 262
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:17:15', '2016-04-08 12:17:15', 907);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1148, 'ticket_comment_added', '--- 
:body: Ticket re-opened.
:by: Eddina W.
:by_id: 40
:comment_id: 263
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:18:02', '2016-04-08 12:18:02', 907);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1149, 'ticket_reopened', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:email: djwilliams@kelsan.biz
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
', 'f', '2016-04-08 12:18:02', '2016-04-08 12:18:02', 908);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1150, 'ticket_comment_added', '--- 
:body: Ticket re-opened.
:by: Eddina W.
:by_id: 40
:comment_id: 263
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:18:02', '2016-04-08 12:18:02', 909);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1151, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Eddina W.
:by_id: 40
:changes: 
  status: 
  - closed
  - open
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
', 'f', '2016-04-08 12:18:02', '2016-04-08 12:18:02', 910);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1152, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Eddina W.
:by_id: 40
:comment_id: 264
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:18:24', '2016-04-08 12:18:24', 911);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1153, 'ticket_reassigned', '--- 
:assigned_to: Elizabeth H.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
:to: Elizabeth H.
:to_id: 9
', 'f', '2016-04-08 12:18:24', '2016-04-08 12:18:24', 912);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1154, 'ticket_comment_added', '--- 
:body: Assigned to Elizabeth Heaton.
:by: Eddina W.
:by_id: 40
:comment_id: 264
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 12:18:24', '2016-04-08 12:18:24', 913);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1155, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Eddina W.
:by_id: 40
:changes: 
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
', 'f', '2016-04-08 12:18:24', '2016-04-08 12:18:24', 914);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1156, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Eddina W.
:by_id: 40
:comment_id: 265
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 13:12:25', '2016-04-08 13:12:25', 915);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1157, 'ticket_closed', '--- 
:assigned_to: Elizabeth H.
:by: Eddina W.
:by_id: 40
:device_ids: []

:due_at: 
:email: djwilliams@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
', 'f', '2016-04-08 13:12:25', '2016-04-08 13:12:25', 916);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1158, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Eddina W.
:by_id: 40
:comment_id: 265
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 13:12:25', '2016-04-08 13:12:25', 917);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1159, 'ticket_updated', '--- 
:assigned_to: Elizabeth H.
:by: Eddina W.
:by_id: 40
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
', 'f', '2016-04-08 13:12:25', '2016-04-08 13:12:25', 918);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1160, 'ticket_comment_added', '--- 
:body: Assigned to Eddina Williams.
:by: Monty K.
:by_id: 5
:comment_id: 266
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 13:26:47', '2016-04-08 13:26:47', 919);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1161, 'ticket_reassigned', '--- 
:assigned_to: Eddina W.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
:to: Eddina W.
:to_id: 40
', 'f', '2016-04-08 13:26:47', '2016-04-08 13:26:47', 920);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1162, 'ticket_comment_added', '--- 
:body: Assigned to Eddina Williams.
:by: Monty K.
:by_id: 5
:comment_id: 266
:comment_name: "Ticket #70"
:ticket_id: 70
:ticket_summary: Report#36005148(Order_Entry_Batch_Update)
', 'f', '2016-04-08 13:26:47', '2016-04-08 13:26:47', 921);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1163, 'ticket_updated', '--- 
:assigned_to: Eddina W.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: edi@kelsan.biz
:summary: Report#36005148(Order_Entry_Batch_Update)
:ticket_id: 70
', 'f', '2016-04-08 13:26:47', '2016-04-08 13:26:47', 922);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1164, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 267
:comment_name: "Ticket #54"
:ticket_id: 54
:ticket_summary: Connect With Us [#582]
', 'f', '2016-04-08 13:27:14', '2016-04-08 13:27:14', 923);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1165, 'ticket_closed', '--- 
:assigned_to: Teresa F.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#582]
:ticket_id: 54
', 'f', '2016-04-08 13:27:14', '2016-04-08 13:27:14', 924);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1166, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 267
:comment_name: "Ticket #54"
:ticket_id: 54
:ticket_summary: Connect With Us [#582]
', 'f', '2016-04-08 13:27:14', '2016-04-08 13:27:14', 925);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1167, 'ticket_updated', '--- 
:assigned_to: Teresa F.
:by: Monty K.
:by_id: 5
:changes: 
  status: 
  - open
  - closed
  status_updated_at: 
  - "2016-04-07"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#582]
:ticket_id: 54
', 'f', '2016-04-08 13:27:15', '2016-04-08 13:27:15', 926);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1168, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: no-reply
:by_id: 37
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#584]
:ticket_id: 71
', 'f', '2016-04-08 15:06:11', '2016-04-08 15:06:11', 927);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1169, 'user_created', '--- 
:source: :user
:user_email: mailer-daemon@s12p02o145.mxlogic.net
:user_id: 43
', 'f', '2016-04-08 15:11:11', '2016-04-08 15:11:11', 928);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1170, 'ticket_opened', '--- 
:assigned_to: unassigned
:by: mailer-daemon
:by_id: 43
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o145.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 72
', 'f', '2016-04-08 15:11:12', '2016-04-08 15:11:12', 929);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1171, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Lee T.
:by_id: 3
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: mailer-daemon@s12p02o145.mxlogic.net
:summary: "Warning: could not send message for past 4 hours"
:ticket_id: 72
', 'f', '2016-04-08 15:41:09', '2016-04-08 15:41:09', 930);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1172, 'ticket_updated', '--- 
:assigned_to: unassigned
:by: Monty K.
:by_id: 5
:changes: 
  category: 
  - 
  - Unspecified
  first_sub_cat: 
  - 
  - Unspecified
  status_updated_at: 
  - 
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#584]
:ticket_id: 71
', 'f', '2016-04-08 16:16:10', '2016-04-08 16:16:10', 930);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1173, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 268
:comment_name: "Ticket #71"
:ticket_id: 71
:ticket_summary: Connect With Us [#584]
', 'f', '2016-04-08 16:17:33', '2016-04-08 16:17:33', 931);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1174, 'ticket_reassigned', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#584]
:ticket_id: 71
:to: Monty K.
:to_id: 5
', 'f', '2016-04-08 16:17:33', '2016-04-08 16:17:33', 932);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1175, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 268
:comment_name: "Ticket #71"
:ticket_id: 71
:ticket_summary: Connect With Us [#584]
', 'f', '2016-04-08 16:17:33', '2016-04-08 16:17:33', 933);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1176, 'ticket_updated', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:changes: 
  status_updated_at: 
  - "2016-04-08"
  - "2016-04-08"
:device_ids: []

:due_at: 
:past_due: 
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#584]
:ticket_id: 71
', 'f', '2016-04-08 16:17:33', '2016-04-08 16:17:33', 934);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1177, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 269
:comment_name: "Ticket #71"
:ticket_id: 71
:ticket_summary: Connect With Us [#584]
', 'f', '2016-04-08 16:17:39', '2016-04-08 16:17:39', 935);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1178, 'ticket_closed', '--- 
:assigned_to: Monty K.
:by: Monty K.
:by_id: 5
:device_ids: []

:due_at: 
:email: mkilburn@kelsan.biz
:past_due: false
:priority: Med
:related_to: ""
:submitter_display_name: no-reply@wufoo.com
:summary: Connect With Us [#584]
:ticket_id: 71
', 'f', '2016-04-08 16:17:39', '2016-04-08 16:17:39', 936);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1179, 'ticket_comment_added', '--- 
:body: Ticket closed.
:by: Monty K.
:by_id: 5
:comment_id: 269
:comment_name: "Ticket #71"
:ticket_id: 71
:ticket_summary: Connect With Us [#584]
', 'f', '2016-04-08 16:17:39', '2016-04-08 16:17:39', 937);

INSERT INTO activities(id, "action", info, dismissed, created_at, updated_at, activity_group_id) VALUES (1180, 'ticket_comment_added', '--- 
:body: Assigned to Monty Kilburn.
:by: Monty K.
:by_id: 5
:comment_id: 270
:comment_name: "Ticket #72"
:ticket_id: 72
:ticket_summary: "Warning: