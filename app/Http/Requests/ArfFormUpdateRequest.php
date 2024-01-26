<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArfFormUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'arf_id'                    =>      'required|exists:arf_forms,id',
            'arf_date'                  =>      'required|date',
            'arf_emp_id'                =>      'nullable|string',
            'arf_name'                  =>      'required|string|max:255',
            'arf_contact_details'       =>      'nullable|string|max:255',
            'arf_email'                 =>      'required|string|max:255',
            'arf_laptop_asset_code'     =>      'nullable|string|max:255',
            'arf_laptop_date_issued'    =>      'nullable|string|max:255',
            'arf_laptop_remarks'        =>      'nullable|string|max:255',
            'arf_laptop_brand'          =>      'nullable|string|max:255',
            'arf_sim_asset_code'        =>      'nullable|string|max:255',
            'arf_sim_date_issued'       =>      'nullable|string|max:255',
            'arf_sim_remarks'           =>      'nullable|string|max:255',
            'arf_sim_brand'             =>      'nullable|string|max:255',
            'arf_tablet_asset_code'     =>      'nullable|string|max:255',
            'arf_tablet_date_issued'    =>      'nullable|string|max:255',
            'arf_tablet_remarks'        =>      'nullable|string|max:255',
            'arf_tablet_brand'          =>      'nullable|string|max:255',
            'arf_monitor_asset_code'    =>      'nullable|string|max:255',
            'arf_monitor_date_issued'   =>      'nullable|string|max:255',
            'arf_monitor_remarks'       =>      'nullable|string|max:255',
            'arf_monitor_brand'         =>      'nullable|string|max:255',
            'arf_desktop_asset_code'    =>      'nullable|string|max:255',
            'arf_desktop_date_issued'   =>      'nullable|string|max:255',
            'arf_desktop_remarks'       =>      'nullable|string|max:255',
            'arf_desktop_brand'         =>      'nullable|string|max:255',
            'arf_mobile_asset_code'     =>      'nullable|string|max:255',
            'arf_mobile_date_issued'    =>      'nullable|string|max:255',
            'arf_mobile_remarks'        =>      'nullable|string|max:255',
            'arf_mobile_brand'          =>      'nullable|string|max:255',
            'has_laptop'                =>      'nullable|in:Y,N',
            'has_sim'                   =>      'nullable|in:Y,N',
            'has_monitor'               =>      'nullable|in:Y,N',
            'has_desktop'               =>      'nullable|in:Y,N',
            'has_tablet'                =>      'nullable|in:Y,N',
            'has_mobile'                =>      'nullable|in:Y,N'
        ];
    }
}
