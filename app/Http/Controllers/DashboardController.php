<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $currentPage = 'dashboard';
        return view('pages.dashboard.index',compact('currentPage'));
    }

    public function viewSettings(){
        $setting = Settings::get()->first();
        return view('pages.settings.detail',compact('setting'));
    }

    public function settingsUpdate(Request $request){
        // Validate the incoming request
        $validated = $request->validate([
            'dist_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'state_code' => 'required',
            'phone' => 'required',
            'gstin_number' => 'required',
            'pan_number' => 'required',
            'profit_calc'=>'required'
        ]);

        $setting = Settings::where('id',1)->get()->first();
        if($setting){
            $setting->dist_name = $validated['dist_name'];
            $setting->address = $validated['address'];
            $setting->city = $validated['city'];
            $setting->state = $validated['state'];
            $setting->state_code = $validated['state_code'];
            $setting->phone = $validated['phone'];
            $setting->gstin_number = $validated['gstin_number'];
            $setting->pan_number = $validated['pan_number'];
            $setting->profit_calc = $validated['profit_calc'];

            $setting->save();
            return response()->json(['success' => true, 'message' => 'Setting updated successfully!']);            

        }
    }
    
}