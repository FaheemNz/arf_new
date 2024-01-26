<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Services\ImportService;


class DailyAssetImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:asset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Assets';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ImportService::getAssets();
    }
}
