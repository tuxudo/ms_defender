<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Ms_defender_model::class, function (Faker\Generator $faker) {

    return [
        'cloud_automatic_sample_submission' => $faker->boolean(),
        'cloud_diagnostic_enabled' => $faker->boolean(),
        'cloud_enabled' => $faker->boolean(),
        'definitions_updated' => $faker->dateTimeBetween('-4 months', 'now'),
        'definitions_version' => $faker->numberBetween(70000, 100000),
        'app_version' => $faker->randomElement(['100.83.7118', '100.33.8173', '100.93.5112']),
        'licensed' => $faker->boolean(),
        'log_level' => $faker->randomElement(['info', 'debug', 'verbose', 'silent']),
        'real_time_protection_available' => $faker->boolean(),
        'real_time_protection_enabled' => $faker->boolean(),
        'release_ring' => $faker->randomElement(['Production', 'Development']),
        'erd_machine_id' => $faker->unique()->regexify('[A-Z0-9]{3}[CDFGHJKLMNPQRSTVWXYZ][123456789CDFGHJKLMNPQRTVWXY][A-Z0-9]{3}'),
        'erd_early_preview_enabled' => $faker->boolean(),
        'healthy' => $faker->boolean(),
        'machine_guid' => $faker->unique()->regexify('[A-Z0-9]{3}[CDFGHJKLMNPQRSTVWXYZ][123456789CDFGHJKLMNPQRTVWXY][A-Z0-9]{3}'),
        'org_id' => $faker->randomElement(['7FF0DBB6-F007-4C11-80BD-0AD617A907D9', '1D0E656C-AFD2-4932-8897-C848CB794A24', 'A4CCD4D9-271C-4CF6-B723-9CA8C856A13B2']),
        'cloud_auto_sample_submission_consent' => $faker->randomElement(['safe', 'unsafe', 'tacos']),
        'engine_version' => $faker->randomElement(['3.0', '3.1', '3.1.2']),
        'real_time_protection_subsystem' => $faker->randomElement(['kernel_extension', 'none', 'bees?']),
    ];
});
