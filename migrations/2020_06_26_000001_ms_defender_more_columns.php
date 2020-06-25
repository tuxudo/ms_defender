<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class MsDefenderMoreColumns extends Migration
{
    private $tableName = 'ms_defender';

    public function up()
    {
        $capsule = new Capsule();

        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->renameColumn('engine_version', 'app_version');
        });

        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->string('real_time_protection_subsystem')->nullable();
            $table->string('cloud_auto_sample_submission_consent')->nullable();
            $table->string('engine_version')->nullable();

            $table->index('real_time_protection_subsystem');
            $table->index('cloud_auto_sample_submission_consent');
            $table->index('engine_version');
        });
    }
    
    public function down()
    {
        $capsule = new Capsule();

        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->dropColumn('real_time_protection_subsystem');
            $table->dropColumn('cloud_auto_sample_submission_consent');
            $table->dropColumn('engine_version');
        });

        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->renameColumn('app_version', 'engine_version');
        });
    }
}
