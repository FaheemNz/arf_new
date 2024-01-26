<?php

namespace App\Http\Controllers;

use App\Models\ArfForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if( empty($request->search_main) || $request->search_main == NULL ){
            return view('search', [
                'results' => [],
                'search_main' => $request->search_main
            ]);
        }

        $query = ArfForm::query();

        $query = $query->where('emp_id', '=', $request->search_main)
                       ->orWhere('name', 'LIKE', '%' . $request->search_main . '%');
                       
        
        $query = $query->orderBy('arf_forms.name', 'ASC')->get();

        return view('search', [
            'results' => $query,
            'search_main' => $request->search_main
        ]);
    }
    
    public function searchAsset(Request $request)
    {
        $table = $request->table;
        
        if(!is_string($table)){
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid Table Name'
            ]);
        }
        
        $result = DB::table($table)
            ->whereNull('arf_form_id')
            ->where('status', 'Active')
            ->whereNull('deleted_at')
            ->select('id', DB::raw('asset_code AS text'))
            ->orderBy('asset_code', 'DESC')
            ->get();
        
        $table = rtrim($table, 's');
        
        if(empty($result)){
            return response()->json([
                'success' => false,
                'message' => 'Asset is not available.',
                'type' => $table
            ]);    
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Asset is Available',
            'data'    => $result,
            'type'    => $table
        ]);
    }

    public function getBrands(Request $request)
    {
        $type = $request->input('type');

        if(!$type){
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid Asset Type'
            ]);
        }

        if(!in_array($type, ['Laptop', 'Tablet', 'Mobile', 'Desktop', 'Monitor', 'Sim'])){
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid Asset Type'
            ]);
        }

        $brands = call_user_func(array('\\App\\Models\\' . $type, 'getBrands'));

        return response()->json([
            'success' => true,
            'message' => 'Brands retrieved Successfully',
            'data'    => $brands
        ]);
    }

    public function getADEmployee(int $empId){
        $ADResponse = Http::get('http://172.30.0.14:8011/api/ActiveDirectory', [
            'EmployeeID' => $empId
        ])->json();

        return response()->json([
            'success' => true,
            'user'    => $ADResponse
        ]);
    }
}
