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

        // Get list of existing indexes
        $sm = $capsule::schema()->getConnection()->getDoctrineSchemaManager();
        $indexesFound = $sm->listTableDetails('ms_defender');

        // Drop old engine_version index
        if ($indexesFound->hasIndex('ms_defender_engine_version_index')) {
            $capsule::schema()->table('ms_defender', function (Blueprint $table) {
                $table->dropIndex('ms_defender_engine_version_index');
            });
        }

        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->string('real_time_protection_subsystem')->nullable();
            $table->string('cloud_auto_sample_submission_consent')->nullable();
            $table->string('engine_version')->nullable();

            $table->index('real_time_protection_subsystem');
            $table->index('cloud_auto_sample_submission_consent');
            $table->index('engine_version');
        });

        // Add index if it doesn't exist
        if (! $indexesFound->hasIndex('ms_defender_app_version_index')) {
            $capsule::schema()->table('ms_defender', function (Blueprint $table) {
                $table->index('app_version');
            });
        }
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
