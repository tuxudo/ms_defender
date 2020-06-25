Microsoft Defender Module
==============

Gets data about Microsoft Defender on the clients. 

Module originally built by Matx (macvfx)


Table Schema
------
* cloud_automatic_sample_submission - boolean - If automatic sample submission is turned on
* cloud_diagnostic_enabled - boolean - If diagnostics are enabled
* cloud_enabled - boolean - If cloud is enabled
* definitions_updated - bigint - Timestamp of when definitions were last updated
* definitions_version - VARCHAR(255) - Anti-malware definitions version
* engine_version - VARCHAR(255) - Engine version
* licensed - boolean - Is product licensed
* log_level - VARCHAR(255) - Set logging level
* real_time_protection_available - boolean - Is real time protection available
* real_time_protection_enabled - boolean - Is real time protection enabled
* release_ring - VARCHAR(255) - Release ring currently in use
* erd_machine_id - VARCHAR(255) - Machine ID in ERD
* erd_early_preview_enabled - boolean - ERD early preview enabled
* healthy - boolean - If defender reports back healthy
* machine_guid - VARCHAR(255) - GUID of machine
* org_id - VARCHAR(255) - Organisation's ID
* real_time_protection_subsystem - VARCHAR(255) - What subsystem is used for real time protection
* cloud_auto_sample_submission_consent - VARCHR(255) - Consent of automatic sample submission
* app_version - VARCHAR(255) - Version of the app used