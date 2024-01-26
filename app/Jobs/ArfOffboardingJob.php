<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Helper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ArfOffboardingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $body;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($_body)
    {
        $this->body = $_body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->body['email'])
                ->send(new \App\Mail\ArfOffboardingNotification($this->body));
    }
}