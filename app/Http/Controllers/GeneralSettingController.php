<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralSetting;
use ImageOptimizer;
use App\Http\Controllers\BusinessSettingsController;
use App\Traits\EnvironmentScope;

class GeneralSettingController extends Controller
{
    use EnvironmentScope;

    public function __construct()
    {
        $this->middleware('permission:generalsetting');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function general()
    {
        $generalsetting = GeneralSetting::first();
        return view("management.general_settings.general_config", compact("generalsetting"));
    }

    public function update_general(Request $request, $id)
    {
        $generalsetting = GeneralSetting::find($id);
        $generalsetting->site_name = $request->name;
        $generalsetting->meta_keyword = $request->meta_keyword;
        $generalsetting->meta_author = $request->meta_author;
        $generalsetting->meta_description = $request->meta_description;
        $generalsetting->address = $request->address;
        $generalsetting->phone = $request->phone;
        $generalsetting->email = $request->email;
        $generalsetting->description = $request->description;
        $generalsetting->facebook = $request->facebook;
        $generalsetting->instagram = $request->instagram;
        $generalsetting->twitter = $request->twitter;
        $generalsetting->youtube = $request->youtube;
        $generalsetting->google_plus = $request->google_plus;

        if($generalsetting->save()){
            return redirect()->route('settings.general')->with('success','GeneralSetting has been updated successfully');
        }
        else{
            return back()->withErrors(['Something went wrong!'])->withInput();
        }
    }

    public function zoom()
    {
        $generalsetting = GeneralSetting::first();
        return view("management.general_settings.zoom_config", compact("generalsetting"));
    }

    public function update_zoom(Request $request, $id)
    {
        $generalsetting = GeneralSetting::find($id);
        $generalsetting->api_key = $request->api_key;
        $generalsetting->api_secret = $request->api_secret;
        $generalsetting->zoom_email = $request->zoom_email;

        $data_validate = array(
            'timezone' => 'required',
            );
        $request->validate($data_validate);
        
        $this->setEnv('ZOOM_CLIENT_KEY', "$request->api_key");
        $this->setEnv('ZOOM_CLIENT_SECRET', "$request->api_secret");
        $this->setEnv('APP_TIMEZONE', "$request->timezone");

        if($generalsetting->save()){
            return redirect()->route('settings.zoom')->with('success','GeneralSetting has been updated successfully');
        }
        else{
            return back()->withErrors(['Something went wrong!'])->withInput();
        }
    }
}
