<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArfFormRequest;
use App\Http\Requests\ArfFormUpdateRequest;
use App\Models\ArfForm;
use App\Models\Department;
use App\Models\Verification;
use Illuminate\Http\Request;
use App\Jobs\ArfJob;
use App\Jobs\ArfUpdateJob;
use App\Jobs\ArfOffboardingJob;
use App\Models\LogActivity;
use App\Models\OfficeLocation;
use App\Services\ArfFormService;
use App\Services\Helper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        dd('Welcome..');

        return;
        $duplicates = ArfForm::select('email', DB::raw('COUNT(*) as `count`'))
        ->where('status', 'Acknowledged')
        ->groupBy('email')
        ->havingRaw('COUNT(*) IN (34)')
        ->get();

        foreach ($duplicates as $duplicate) {
            $arfForms = ArfForm::where('email', $duplicate->email)->where('status', 'Acknowledged')->orderBy('created_at', 'ASC')->get();

            $arfFormToKeep = $arfForms->first();

            // Merge logic
            foreach ($arfForms as $arfForm) {
                if ($arfForm->id != $arfFormToKeep->id) {
                    foreach (['\App\Models\Sim', '\App\Models\Tablet', '\App\Models\Laptop', '\App\Models\Monitor', '\App\Models\Desktop', '\App\Models\Mobile'] as $model) {
                        $model::where('arf_form_id', $arfForm->id)
                            ->update(['arf_form_id' => $arfFormToKeep->id]);
                    }

                    $arfForm->delete();
                }
            }
        }
    }
}
