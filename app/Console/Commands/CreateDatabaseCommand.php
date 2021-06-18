<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;
use config;

/**
 * Database creation console command.
 * Purpose is to create the initial database for the application.
 */
class CreateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:database {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the initial laravel database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $database_name = $this->argument('name') ?: config('database.connections.mysql.database');
        $charset = config("database.connections.mysql.charset", 'utf8mb4');
        $collation = config("database.connections.mysql.collation", 'utf8mb4_unicode_ci');

        config(
            ['database.connections.temp' => [
                'driver' => config("database.connections.mysql.driver"),
                'database' => 'mysql',
                'host' => config("database.connections.mysql.host"),
                'username' => config("database.connections.mysql.username"),
                'password' => config("database.connections.mysql.password")
            ]]
        );

        $dbExist = DB::connection('temp')->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = " . "'" . $database_name . "'");

        if (empty($dbExist)) {
            DB::connection('temp')->statement("CREATE DATABASE IF NOT EXISTS $database_name CHARACTER SET $charset COLLATE $collation");
            $this->info("Database $database_name created");
        } else {
            $this->info("Database $database_name already exists");
        }
        return 0;
    }
}
