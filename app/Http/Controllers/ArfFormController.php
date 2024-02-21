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

class ArfFormController extends Controller
{
    public function index()
    {
        return view('arf_form.create', [
            'departments'       =>      Department::orderBy('name')->get(),
            'laptopBrands'      =>      ArfForm::getLaptopBrands(),
            'desktopBrands'     =>      ArfForm::getDesktopBrands(),
            'monitorBrands'     =>      ArfForm::getMonitorBrands(),
            'tabletBrands'      =>      ArfForm::getTabletBrands(),
            'simNetworks'       =>      ArfForm::getSimNetworks(),
            'officeLocations'   =>      OfficeLocation::all()
        ]);
    }

    public function create(ArfFormRequest $arfFormRequest, ArfForm $arfForm)
    {
        if( ! auth()->user()->can('add', $arfForm) ){
            return redirect()
                    ->back()
                    ->withErrors(['You are not authorized to create ARF Form']);
        }

        try {
            $arfData = $arfFormRequest->validated();
            
            $existingArfFormCheck = ArfForm::where('emp_id', $arfData['arf_emp_id'])->where('status', 'Acknowledged')->first();

            if( $existingArfFormCheck ){
                $link = "Existing ARF Form Link: http://5.195.13.174:57134/arf-edit/{$existingArfFormCheck->emp_id}";
                return redirect()->back()->withErrors(['An ARF Form Already Exists for this Employee. ' . $link]);
            }

            Log::info('### ARF Form Created - Started ###', [
                'By'       => auth()->user()->name,
                'Time'     => now(),
                'Request'  => json_encode($arfFormRequest->validated())
            ]);

            $token = Verification::getToken();
            
            $body = [
                'name'      =>      $arfData['arf_name'],
                'email'     =>      $arfData['arf_email'],
                'emp_id'    =>      $arfData['arf_emp_id'],
                'url'       =>      Verification::getUrl($token),
                'items'     =>      ArfFormService::getItems($arfData)
            ];
            
            dispatch(new ArfJob($body, $arfData, $token));
            
            return back()->with('success', 'ARF Saved Successfully');

            Log::info('### ARF Form Created - Success ###', [
                'By'        =>      auth()->user()->name,
                'Time'      =>      now(),
                'Request'   =>      json_encode($arfFormRequest->validated()),
                'Token'     =>      $token,
                'Name'      =>      $arfData['arf_name'],
                'Email'     =>      $arfData['arf_email']
            ]);
            
        } catch (\Exception $exception) {
            LogActivity::add('Exception', json_encode(Helper::getErrorDetails($exception)), 0, 'NULL_User');
            
            return back()->withErrors([$exception->getMessage()]);
        }
    }
    
    public function edit(Request $request, int $id)
    {
        if( ! auth()->user()->can('edit', $arfForm) ){
            return redirect()
                    ->back()
                    ->withErrors(['You are not authorized to create ARF Form']);
        }

        $arf = ArfForm::where('emp_id', $id)->first();;

        if(!$arf){
            return view('arfmessage', [
                'title'   => 'Not Found',
                'message' => 'No Employee found with the ID: ' . $id
            ]);
        }

        if($arf->status == 'In Active'){
            return view('arfmessage', [
                'title' => 'ARF Form In Active',
                'message' => 'This ARF Form has been offboarded and is now In-Active'
            ]);
        }

        return view('arf_form.edit', [
            'arf'               =>      $arf,
            'laptopBrands'      =>      ArfForm::getLaptopBrands(),
            'desktopBrands'     =>      ArfForm::getDesktopBrands(),
            'monitorBrands'     =>      ArfForm::getMonitorBrands(),
            'tabletBrands'      =>      ArfForm::getTabletBrands(),
            'simNetworks'       =>      ArfForm::getSimNetworks(),
            'printerBrands'     =>      ArfForm::getPrinterBrands()
        ]);
    }

    public function update(ArfFormUpdateRequest $arfFormUpdateRequest)
    {
        try {
            Log::info('### ARF Form - New Asset Registeration Request ###', [
                'Request'     => $arfFormUpdateRequest,
                'By'          => auth()->user()->name  
            ]);

            $arfData = $arfFormUpdateRequest->validated();

            $token = Verification::getToken();
            $arfItems = ArfFormService::getItems($arfData);
            
            if( empty($arfItems) ){
                return back()->with('success', 'Please Add Assets to Update');
            }

            $body = [
                'name'      =>      $arfData['arf_name'],
                'email'     =>      $arfData['arf_email'],
                'url'       =>      Verification::getUrl($token),
                'items'     =>      $arfItems
            ];
            
            dispatch(new ArfUpdateJob($body, $arfData, $token, $arfData['arf_id']));
            
            Log::info('### ARF Form - New Asset Registeration Request - Success ###', [
                'Success'   => 'True'  
            ]);

            return back()->with('success', 'ARF Updated Successfully');
            
        } catch (\Exception $exception) {
            LogActivity::add('Exception_Asset_Update', json_encode(Helper::getErrorDetails($exception)), $arfFormUpdateRequest['arf_id'], 'NULL_User');
            
            Log::info('### ARF Form - New Asset Registeration Request - Exception ###', [
                'Exception'     => json_encode(Helper::getErrorDetails($exception)),
                'By'            => auth()->user()->name  
            ]);

            return back()->withErrors([$exception->getMessage()]);
        }
    }

    public function destroy(Request $request, int $id)
    {
        $arf = ArfForm::where('emp_id', $id)->where('status', '!=', 'In Active')->first();

        if(!$arf){
            return view('arfmessage', [
                'title'   => 'Not Found',
                'message' => 'Already Offboarded Or No Employee found with the ID: ' . $id,
                'color'   => 'orange'
            ]);
        }
        
        return view('arf_form.destroy', [
            'arf'  =>  $arf
        ]);
    }

    public function startOffboarding(Request $request, int $id)
    {
        Log::info('### ARF Form - Offboarding Started ###', [
            'Request'     => $request->all(),
            'Employee_Id' => $id,
            'By' => auth()->user()->name
        ]);

        try {
            DB::beginTransaction();

            $arf = ArfForm::where('emp_id', $id)
                ->where('id', $request->arf_id)
                ->where('status', '!=', 'In Active')
                ->first();

            if(!$arf){
                return view('arfmessage', [
                    'title' => 'ARF is already In Active',
                    'message' => 'Please check this user has already been off-boarded'
                ]);
            }
            
            $body = [
                'name'      =>      $arf->name,
                'email'     =>      $arf->email,
                'items'     =>      ArfFormService::getItems($request->all())
            ];

            ArfFormService::unRegisterAssets($request->all(), $arf);

            $arf->status = 'In Active';

            $arf->save();
            
            DB::commit();

            Log::info('### ARF Form - Offboarding Success ###', [
                'Employee_Id' => $id
            ]);

            dispatch(new ArfOffboardingJob($body));

            return view('arfmessage', [
                'title'   => 'Offboarding Successful',
                'message' => 'The User with Employee Id: ' . $id . ' has been offboarded successfully',
                'color'   => 'green'
            ]);
            
        } catch (\Exception $exception) {
            LogActivity::add('Exception_Asset_Update', json_encode(Helper::getErrorDetails($exception)), $id, 'NULL_User');
            
            DB::rollBack();

            Log::info('### ARF Form - Offboarding Exception ###', [
                'Request'     => $request->all(),
                'Employee_Id' => $id,
                'Exception'   => Helper::getErrorDetails($exception)
            ]);

            return back()->withErrors([$exception->getMessage()]);
        }
    }

    public function freeAsset(Request $request){
        
        if( !$request->asset_id || !$request->table ){
            return response()->json([
                'success' => false,
                'message' => 'Please provide asset_id or Table Name'
            ]);
        }
        
        try {
            DB::beginTransaction();

            $asset = DB::table($request->table)->where('id', $request->asset_id)->get();

            if( ! $asset ){
                return response()->json([
                    'success' => FALSE,
                    'message' => 'No Asset Found'
                ]);
            }

            $asset = $asset[0];

            $arf = DB::table('arf_forms')->where('id', $asset->arf_form_id)->get();

            if( ! $arf ){
                return response()->json([
                    'success' => FALSE,
                    'message' => 'No ARF Form found with the asset'
                ]);
            }

            $arf = $arf[0];

            DB::table($request->table)->where('id', $request->asset_id)->update([
                'status'        => 'Active',
                'arf_form_id'   => NULL,
                'history'       => $asset->history . ", Previous User: [Name: {$arf->name}, Emp_ID: {$arf->emp_id}, Email: {$arf->email}, Status: {$asset->status}, Date: {$asset->updated_at}]"
            ]);

            DB::commit();

            Log::info('### ARF Form - Freeing Asset ###', [
                'Request'     => $request->all(),
                'Table'       => $request->table,
                'Asset_ID'    => $request->asset_id,
                'By'          => auth()->user()->name
            ]);

            return response()->json([
                'success' => TRUE,
                'message' => 'Success'
            ]);
        } catch(\Exception $exception){
            DB::rollBack();

            Log::info('### ARF Form - Offboarding Exception ###', [
                'Request'     => $request->all(),
                'Exception'   => Helper::getErrorDetails($exception)
            ]);

            return response()->json([
                'success' => FALSE,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
