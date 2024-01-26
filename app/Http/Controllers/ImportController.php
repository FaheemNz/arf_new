<?php

namespace App\Http\Controllers;

use App\Imports\LaptopImport;
use App\Imports\SimImport;
use App\Imports\DesktopImport;
use App\Imports\MonitorImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Services\ImportService;


class ImportController extends Controller
{
    public function import($asset){
        return view('import.asset', [
            'asset' => $asset
        ]);
    }

    public function assetImport(Request $request){
        $file  = $request->file('file');
        $asset = $request->input('asset');
        
        if( $asset == 'laptops' ){
            Excel::import(new LaptopImport(), $file);
        }
        if( $asset == 'desktops' ){
            Excel::import(new DesktopImport(), $file);
        }
        if( $asset == 'sims' ){
            Excel::import(new SimImport(), $file);
        }
        if( $asset == 'monitors' ){
            Excel::import(new MonitorImport(), $file);
        }
        
        return redirect()->back()->with('success', 'Data imported successfully.');
    }

    public function refreshAssets(Request $request){
        try {
            ImportService::getAssets();

            return response()->json([
                'success' => true
            ]);  
        } catch(\Exception $exception){
            return response()->json([
                'success' => false
            ]);
        }
    }
}
