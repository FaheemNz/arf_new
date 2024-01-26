<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\ArfNotification;
use App\Models\ArfForm;
use App\Models\LogActivity;
use App\Models\Verification;
use App\Services\ArfFormService;
use App\Services\Helper;
use Illuminate\Support\Facades\Log;
use Exception;

class ArfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $details;
    public $arfData;
    public $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details, $arfData, $token)
    {
        $this->details = $details;
        $this->arfData = $arfData;
        $this->token   = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Log::info('### ARF Form Job Started ###', [
                'Arf_Data' => json_encode( $this->arfData )
            ]);

            $arf = ArfForm::saveData($this->arfData);
            
            ArfFormService::registerAssets($this->arfData, $arf->id);

            Verification::register($this->token, $arf->id, $this->arfData['arf_email']);

            $logDetails = ArfFormService::getItems($this->arfData);
            
            LogActivity::add('Asset_Registered_With_User', json_encode($logDetails), $arf->id, $this->arfData['arf_name']);
            
            Mail::to($this->details['email'])
            ->send(new ArfNotification($this->details));

        } catch (\Exception $exception) {
        
            LogActivity::add('Email_Failed', json_encode(Helper::getErrorDetails($exception)), 0, $this->details['email']);

            Log::info('### ARF Form Job Started - Failure ###', [
                'Exception' => json_encode(Helper::getErrorDetails($exception))
            ]);
        }
    }
}
