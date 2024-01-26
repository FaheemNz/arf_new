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
use Exception;

class ArfUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $details;
    public $arfData;
    public $token;
    public $arf_form_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details, $arfData, $token, $arf_form_id)
    {
        $this->details = $details;
        $this->arfData = $arfData;
        $this->token   = $token;
        $this->arf_form_id = $arf_form_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $arf = ArfForm::find($this->arf_form_id);

            $arf->status = 'Waiting Confirmation';
            $arf->updated_at = now();

            $arf->save();
            
            ArfFormService::registerAssets($this->arfData, $arf->id);

            Verification::register($this->token, $arf->id, $this->arfData['arf_email']);

            $logDetails = ArfFormService::getItems($this->arfData);

            Mail::to($this->details['email'])
                ->send(new ArfNotification($this->details));
            
            LogActivity::add('Asset_Updated_And_Registered_With_User', json_encode($logDetails), $arf->id, $this->arfData['arf_name']);
            
        } catch (\Exception $exception) {
        
            LogActivity::add('Email_Failed_Asset_Update_Registeration', json_encode(Helper::getErrorDetails($exception)), 0, $this->details['email']);
        }
    }
}
