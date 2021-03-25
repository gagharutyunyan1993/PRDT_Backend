<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ide extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ide:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh all ide-helper configs';

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
        Artisan::call('ide-helper:eloquent');
        Artisan::call('ide-helper:models', ['--no-interaction' => 'Yes']);
        Artisan::call('ide-helper:meta');
        Artisan::call('ide-helper:generate');
        return true;
    }
}
