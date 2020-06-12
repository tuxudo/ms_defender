<?php

use munkireport\models\MRModel as Eloquent;

class Ms_defender_model extends Eloquent
{
    protected $table = 'ms_defender';

    protected $fillable = [
      'serial_number',
      'cloud_automatic_sample_submission',
      'cloud_diagnostic_enabled',
      'cloud_enabled',
      'definitions_updated',
      'definitions_version',
      'engine_version',
      'licensed',
      'log_level',
      'real_time_protection_available',
      'real_time_protection_enabled',
      'release_ring',
      'erd_machine_id',
      'erd_early_preview_enabled',
      'healthy',
      'machine_guid',
      'org_id',
    ];

    public $timestamps = false;
}
