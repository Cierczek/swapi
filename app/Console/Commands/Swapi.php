<?php

namespace App\Console\Commands;

use App\Services\SwapiService;
use Illuminate\Console\Command;


class Swapi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:swapi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $result = (new SwapiService())->importSwapiData('people');

        if ($result) {
            $result = (new SwapiService())->importSwapiData('starship');
        }

        return $result;
    }
}
