<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\BackupHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaariBackupController extends Controller
{
    // should be update : redirect after download and show error message
    public function download(Request $request)
    {
        $frequency = $request->input('frequency');

        // Validate the provided frequency
        $allowedFrequencies = ['daily', 'weekly', 'monthly', 'yearly'];

        if (!in_array($frequency, $allowedFrequencies)) {
            abort(400, 'Invalid frequency.');
        }
        return $this->downloadBackup($frequency);
    }

    private function downloadBackup($frequency)
    {
        // Define the backup folder name
        $backupFolderName = 'backup';

        // Define the backup filename pattern
        $backupFileNamePattern = 'Backup-%s.sql';

        // Define the start and end dates for the backup based on the frequency
        $startDate = null;
        $endDate = null;

        if ($frequency === 'daily') {
            $startDate = Carbon::today();
            $endDate = Carbon::today();
        } elseif ($frequency === 'weekly') {
            $startDate = Carbon::now()->subWeek();
            $endDate = Carbon::today();
        } elseif ($frequency === 'monthly') {
            $startDate = Carbon::now()->subMonth();
            $endDate = Carbon::today();
        } elseif ($frequency === 'yearly') {
            $startDate = Carbon::now()->subYear();
            $endDate = Carbon::today();
        } else {
            abort(400, 'Invalid frequency.');
        }

        // Generate the backup file name based on the database name and date
        $backupFileName = sprintf($backupFileNamePattern, $endDate->format('Y-m-d'));

        // Get the backup file path
        $backupFilePath = storage_path("app/$backupFolderName/$backupFileName");

        // Delete the previous backup file if it exists
        if (file_exists($backupFilePath)) {
            unlink($backupFilePath);
        }

        // Create the backup folder if it doesn't exist
        if (!is_dir(dirname($backupFilePath))) {
            mkdir(dirname($backupFilePath), 0777, true);
        }

        // Get the database connection details from the .env file
        $databaseUser = env('DB_USERNAME');
        $databasePassword = env('DB_PASSWORD');
        $databaseHost = env('DB_HOST');
        $databaseName = env('DB_DATABASE');

        // Get the list of tables to back up
        $tables = collect(DB::select('SHOW TABLES'))->pluck('Tables_in_' . $databaseName)->toArray();

        // Iterate over each table and generate separate SQL files
        foreach ($tables as $tableName) {
            $tableBackupFileName = sprintf($backupFileNamePattern, $tableName);
            $tableBackupFilePath = storage_path("app/$backupFolderName/$tableBackupFileName");

            // Generate the backup command for the current table with date filter
            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s %s %s --where="DATE(created_at) >= \'%s\' AND DATE(created_at) <= \'%s\'" > %s',
                $databaseUser,
                $databasePassword,
                $databaseHost,
                $databaseName,
                $tableName,
                $startDate->toDateString(),
                $endDate->toDateString(),
                $tableBackupFilePath
            );

            // Execute the backup command
            exec($command);
        }

        // Merge the separate table backup files into a single backup file
        $mergedBackupFilePath = storage_path("app/$backupFolderName/$backupFileName");

        // Delete the previous merged backup file if it exists
        if (file_exists($mergedBackupFilePath)) {
            unlink($mergedBackupFilePath);
        }

        // Append the table backup files to the merged backup file
        foreach ($tables as $tableName) {
            $tableBackupFileName = sprintf($backupFileNamePattern, $tableName);
            $tableBackupFilePath = storage_path("app/$backupFolderName/$tableBackupFileName");

            if (file_exists($tableBackupFilePath)) {
                file_put_contents($mergedBackupFilePath, file_get_contents($tableBackupFilePath), FILE_APPEND);
                unlink($tableBackupFilePath);
            }
        }

        // Check if the merged backup file was created successfully
        if (file_exists($mergedBackupFilePath)) {
            // Store backup info
            BackupHistory::create([
                'name' => 'Backup-'.$endDate->format('Y-m-d'),
                'status' => 1,
            ]);

            // Generate a download response
            return response()->download($mergedBackupFilePath, $backupFileName)->isRedirect('');
            // test


        } else {
            abort(400, 'Failed to create database backup.');
        }
    }
}
