<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class MsDefender extends Migration
{
    public function up()
    {
        $capsule = new Capsule();
        $capsule::schema()->create('ms_defender', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial_number')->unique();
            $table->boolean('cloud_automatic_sample_submission')->nullable();
            $table->boolean('cloud_diagnostic_enabled')->nullable();
            $table->boolean('cloud_enabled')->nullable();
            $table->bigInteger('definitions_updated')->nullable();
            $table->string('definitions_version')->nullable();
            $table->string('engine_version')->nullable();
            $table->boolean('licensed')->nullable();
            $table->string('log_level')->nullable();
            $table->boolean('real_time_protection_available')->nullable();
            $table->boolean('real_time_protection_enabled')->nullable();
            $table->string('release_ring')->nullable();
            $table->string('erd_machine_id')->nullable();
            $table->boolean('erd_early_preview_enabled')->nullable();
            $table->boolean('healthy')->nullable();
            $table->string('machine_guid')->nullable();
            $table->string('org_id')->nullable();

            $table->index('serial_number');
            $table->index('cloud_automatic_sample_submission');
            $table->index('cloud_diagnostic_enabled');
            $table->index('cloud_enabled');
            $table->index('definitions_version');
            $table->index('engine_version');
            $table->index('licensed');
            $table->index('log_level');
            $table->index('real_time_protection_available');
            $table->index('real_time_protection_enabled');
            $table->index('release_ring');
            $table->index('erd_machine_id');
            $table->index('healthy');
            $table->index('erd_early_preview_enabled');
            $table->index('machine_guid');
            $table->index('org_id');
        });
    }

    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->dropIfExists('ms_defender');
    }
}
