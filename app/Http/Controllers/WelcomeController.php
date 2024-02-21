<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArfFormRequest;
use App\Http\Requests\ArfFormUpdateRequest;
use App\Models\ArfForm;
use App\Models\Sim;
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
    // public function index()
    // {
    //     dd('Welcome..');

    //     return;
    //     $duplicates = ArfForm::select('email', DB::raw('COUNT(*) as `count`'))
    //     ->where('status', 'Acknowledged')
    //     ->groupBy('email')
    //     ->havingRaw('COUNT(*) IN (34)')
    //     ->get();

    //     foreach ($duplicates as $duplicate) {
    //         $arfForms = ArfForm::where('email', $duplicate->email)->where('status', 'Acknowledged')->orderBy('created_at', 'ASC')->get();

    //         $arfFormToKeep = $arfForms->first();

    //         // Merge logic
    //         foreach ($arfForms as $arfForm) {
    //             if ($arfForm->id != $arfFormToKeep->id) {
    //                 foreach (['\App\Models\Sim', '\App\Models\Tablet', '\App\Models\Laptop', '\App\Models\Monitor', '\App\Models\Desktop', '\App\Models\Mobile'] as $model) {
    //                     $model::where('arf_form_id', $arfForm->id)
    //                         ->update(['arf_form_id' => $arfFormToKeep->id]);
    //                 }

    //                 $arfForm->delete();
    //             }
    //         }
    //     }
    // }

    public function index()
    {
        return;
        // \DB::table('arf_forms')->insert([
        //     array(
        //             "name" => "Rajeev Kumar",
        //             "email" => "Krishna.Rajeevkumar@gardinia.ae",
        //             "emp_id" => "8240",
        //             "department_id" => 11,
        //             "office_location_id" => 7,
        //             'status' => 'Acknowledged'
        //         ),
        // ]);

        // return;

        
        $this->updateSim();
        return;

        for( $i=0; $i<count($arf_forms); $i++ ){
            $arfCheck = ArfForm::where('name', 'LIKE', '%'. $arf_forms[$i]['name'] . '%')->where('emp_id', $arf_forms[$i]['emp_id'])->first();

            if( empty($arfCheck) ){
                //echo $arfCheck->name . '<br />';

                ArfForm::create([
                    'name'   => $arf_forms[$i]['name'],
                    'email'  => $arf_forms[$i]['email'],
                    'emp_id' => $arf_forms[$i]['emp_id'],
                    'created_at' => now(),
                    'status' => 'Acknowledged',
                    'department_id' => $arf_forms[$i]['department_id'],
                    'office_location_id' => $arf_forms[$i]['office_location_id'] 
                ]);
            }
        }
    }

    public function updateSim()
    {
        

        

        for($i=0; $i<count($sims); $i++)
        {
            $arf = ArfForm::where('name', '=', $sims[$i]['name'])->first();
            $sim = Sim::where('asset_code', '=', $sims[$i]['asset_code'])->first();

            if( !empty($arf) && !empty($sim) )
            {
                $sim->update([
                    'arf_form_id' => $arf->id
                ]);
            }
        }
    }
}
