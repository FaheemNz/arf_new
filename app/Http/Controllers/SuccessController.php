<?php

namespace App\Http\Controllers;

use App\Models\ArfForm;
use App\Models\LogActivity;
use App\Models\Verification;
use App\Services\ArfFormService;
use App\Services\Helper;
use Illuminate\Support\Facades\DB;

class SuccessController extends Controller
{
    public function index(string $token)
    {
        try {
            DB::beginTransaction();
            
            if (!$token) {
                LogActivity::add('Email Verification Token Error', 'No Token was provied when Verifying the Email', 0, 'NULL_User');
                
                return view('arfmessage', [
                    'title' => 'Invalid Token',
                    'message' => 'The Verification token is required'
                ]);
            }

            $verification = Verification::where('token', $token)->first();

            if (!$verification) {
                return view('arfmessage', [
                    'title' => 'Invalid Token',
                    'message' => 'The Verification token is not valid'
                ]);
            }
            
            if($verification->user_has_verified == true){
                LogActivity::add('Email Already Verified', 'User tried to verified the Email Again', 0, 'User_Token: ' . $token);
                
                return view('arfmessage', [
                    'title' => 'Email Already verified',
                    'message' => 'You have already verified the email.'
                ]);
            }
            
            $arf = ArfForm::where('id', $verification->arf_form_id)->first();
            
            $arf->status = 'Acknowledged';
            
            $arf->save();
            
            $verification->user_has_verified = true;
            $verification->remarks = $verification->remarks . ' ::: Email Verification Successful';
            
            $verification->save();
            
            LogActivity::add('Email Verified', 'User has verified the Email', $arf->id, $arf->name);
            
            if(ArfFormService::updateAssetStatus($arf->id, $arf->name)){
                DB::commit();    
            } else {
                LogActivity::add('Asset_Update_Status_Failure', 'No Asset Status was Updated', $arf->id, $arf->name);
            }
            
            return view('success');
            
        } catch (\Exception $exception) {
            DB::rollBack();
            
            LogActivity::add('Exception_When_Verifying', json_encode(Helper::getErrorDetails($exception)), 0, 'User_Token: ' . $token);
        }
    }
}
