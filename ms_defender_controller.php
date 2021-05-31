<?php

/**
 * ms_defender class
 *
 * @package munkireport
 * @author macvfx and tuxudo
 **/
class Ms_defender_controller extends Module_controller
{

    /*** Protect methods with auth! ****/
    function __construct()
    {
        // Store module path
        $this->module_path = dirname(__FILE__);
    }

    /**
     * Get ms_defender healthy information for widget
     *
     **/
    public function get_healthy()
    {
        jsonView(
            $out = Ms_defender_model::selectRaw('healthy, count(*) AS count')
                ->filter()
                ->groupBy('healthy')
                ->orderBy('count', 'desc')
                ->get()
                ->toArray()
            );
    }

    /**
     * Get ms_defender health stats for new widget
    **/
    public function get_health_stats()
    {
        jsonView(
            Ms_defender_model::selectRaw("COUNT(CASE WHEN `healthy` = '1' THEN 1 END) AS 'healthy'")
                ->selectRaw("COUNT(CASE WHEN `healthy` = '0' THEN 1 END) AS 'unhealthy'")
                ->filter()
                ->first()
                ->toLabelCount()
        );
    }

    /**
     * Get ms_defender information for serial_number
     *
     * @param string $serial serial number
     **/
    public function get_data($serial_number = '')
    {
        jsonView(
            Ms_defender_model::selectRaw('healthy, app_version, engine_version, definitions_updated, definitions_version, real_time_protection_available, real_time_protection_enabled, real_time_protection_subsystem, org_id, machine_guid, cloud_enabled, cloud_automatic_sample_submission, cloud_auto_sample_submission_consent, cloud_diagnostic_enabled, licensed, log_level, release_ring, erd_machine_id, erd_early_preview_enabled')
                ->whereSerialNumber($serial_number)
                ->filter()
                ->get()
                ->toArray()
        );
    }
    
} // End class Ms_defender_controller
