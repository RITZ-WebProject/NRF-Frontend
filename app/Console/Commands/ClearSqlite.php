<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearSqlite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clear-sqlite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear kbz sqlite database';

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
        $databaseName = config('database.connections.sqlite.database');
        $this->info('Clearing the SQLite database: ' . $databaseName);
        $this->confirm('This action will remove all data from the SQLite database. Do you wish to continue?');

        DB::connection('sqlite')->getSchemaBuilder()->disableForeignKeyConstraints();

        $tables = DB::connection('sqlite')->getDoctrineSchemaManager()->listTableNames();

        foreach ($tables as $table) {
            DB::connection('sqlite')->table($table)->truncate();
        }

        DB::connection('sqlite')->getSchemaBuilder()->enableForeignKeyConstraints();

        $this->info('SQLite database cleared successfully.');

        return 0;
    }
}
