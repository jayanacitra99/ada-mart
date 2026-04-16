<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateTimezoneCommand extends Command
{
    protected $signature = 'timezone:update';

    protected $description = 'Update timestamps from UTC to Jakarta timezone for all records in all tables';

    public function handle()
    {
        // Get all tables in the database
        $tables = DB::select('SHOW TABLES');

        // Loop through each table
        foreach ($tables as $table) {
            $tableName = reset($table);

            // Check if the table has created_at and updated_at columns
            if (DB::getSchemaBuilder()->hasColumns($tableName, ['created_at', 'updated_at'])) {
                // Update timestamps in the table
                DB::table($tableName)->update([
                    'created_at' => DB::raw('CONVERT_TZ(created_at, "+00:00", "+07:00")'),
                    'updated_at' => DB::raw('CONVERT_TZ(updated_at, "+00:00", "+07:00")')
                ]);
            }
        }

        $this->info('Timestamps updated successfully.');
    }
}
