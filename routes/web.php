<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('check', [Frontend\FrontController::class, 'check'])->name('frontend.check');

require __DIR__ . '/auth.php';
Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');
    echo Artisan::output();
});

Route::get('/reset', function () {
    Artisan::call('migrate:fresh --seed');
    echo Artisan::output();
});

// For development only
Route::get('/clear-all', function () {
    Artisan::call('optimize:clear');
    echo Artisan::output();
});


/* migration */
Route::get('/migrate', function () {
    Artisan::call('migrate');
    echo Artisan::output();
});
/* migration */
Route::get('/migrate/{step}', function ($step) {
    Artisan::call('migrate:refresh', array('--step' => $step));
    echo Artisan::output();
});
/* migration refresh specific file */
Route::get('/migrate-path/{path}', function ($path) {
    Artisan::call('migrate:refresh', array('--path' => 'database/migrations/' . $path));
    echo Artisan::output();
});
/* migration rollback specific file */
Route::get('/migrate-rollback/{path}', function ($path) {
    Artisan::call('migrate:rollback', array('--path' => 'database/migrations/' . $path));
    echo Artisan::output();
});
/* migration group rollback specific file */
Route::get('/rollback-group', function () {
    $path = ['2023_10_31_090334_create_sale_return_details_table.php', '2023_05_23_114404_create_due_installments_table.php', '2023_05_16_105849_create_sale_details_table.php', '2023_05_30_101501_create_due_collects_table.php', '2023_10_31_090308_create_sale_returns_table.php', '2023_05_16_105447_create_sales_table.php'];
    for ($i = 0; $i < count($path); $i++) {
        Artisan::call('migrate:rollback', array('--path' => 'database/migrations/' . $path[$i]));
    }
    echo Artisan::output();
});
/* create symbolic link */
Route::get('/symlink', function () {
    Artisan::call('storage:link');
    echo Artisan::output();
});
/* create symbolic link */
/*Route::get('/route-list', function () {
    Artisan::call('route:list', ['--path' => 'api/v1']);
    echo Artisan::output();
});*/
/* create all seeder */
Route::get('/seeder-all', function () {
    Artisan::call('db:seed');
    echo  Artisan::output();
});
/* specific seeder  */
Route::get('/seeder/{class}', function ($class) {
    Artisan::call('db:seed', array('--class' => $class));
    echo  Artisan::output();
});
/* seeder fresh */
Route::get('/seeder-fresh', function () {
    Artisan::call('migrate:fresh --seed');
    echo  Artisan::output();
});
Route::get('/seeder-refresh', function () {
    Artisan::call('migrate:refresh --seed');
    echo  Artisan::output();
});
/* specific seeder fresh */
Route::get('/seeder-fresh/{class}', function ($class) {
    Artisan::call('migrate:refresh --seed', array('--class' => $class));
    echo  Artisan::output();
});
Route::get('/tinker/{class}', function ($class) {
    Artisan::call('tinker', array('--class' => $class));
    echo  Artisan::output();
});
Route::get('/composer-update', function () {
    $command = 'composer update';
    $output = null;
    $exitCode = 0;

    // Execute the composer update command
    exec($command, $output, $exitCode);
    Route::get('/', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Check if the command executed successfully
    if ($exitCode === 0) {
        return response()->json([
            'message' => 'Composer update completed successfully.',
            'output' => $output,
        ]);
    } else {
        return response()->json([
            'message' => 'Composer update failed.',
            'output' => $output,
        ], 500);
    }
});
Route::get('/migration-file', function () {

    // Define the path to the migrations directory
    $migrationsPath = database_path('migrations');

    // Get a list of all migration files in the directory
    $migrationFiles = File::glob("{$migrationsPath}/*.php");
    //$migrationFiles = File::glob(database_path('migrations/*.php'));

    // Extract just the migration file names (without the path)
    $migrationFileNames = array_map(function ($file) {
        return pathinfo($file, PATHINFO_FILENAME);
    }, $migrationFiles);

    // Display the list of migration file names
    // print_r($migrationFileNames);
    rsort($migrationFileNames);
    $artisan_action = ['migrate', 'rollback', 'clear-all', 'seeder', 'refresh', 'fresh', 'reset', 'rollback', 'status', 'seed'];
    foreach ($migrationFileNames as $file) {
        echo "<form>";
        echo "<input type='checkbox' value='$file'>" . $file . "<br>";
        echo "</form>";
    }
    $action_list = ['migrate', 'migrate-refresh'];
    //2nd way get migration file
    /* $migrationFiles = File::files(database_path('migrations'));

    foreach ($migrationFiles as $file) {
        echo $file->getFilename() . PHP_EOL;
    }*/
});
