<?php

namespace Lenna\Admin\Console;

use Illuminate\Console\Command;
use Lenna\Admin\Models\AdminTablesSeeder;

class InstallCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the admin package';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('migrate');

        $this->call('db:seed',['--class' => AdminTablesSeeder::class]);

        $this->info('Done.');
    }
}
