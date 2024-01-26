<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ArfInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'arf:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initiazez ARF Project';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('migrate:fresh');
        $this->call('optimize:clear');
        $this->call('voyager:install');
        $this->call('db:seed', []);
    }
}
