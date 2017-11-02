<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use App\Device;
use App\Site;
use App\Location;
use Illuminate\Support\HtmlString;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response||\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
            'site_id' => 'sometimes|required|integer|digits_between:1,10',
            'location_id' => 'sometimes|required|integer|digits_between:1,10',
            'device_id' => 'sometimes|required|integer|digits_between:1,10',
            'page' => 'sometimes|required|integer|digits_between:1,10',
        ]);
    
        if (count($request->all()) == 0)
        {
            //Get the device, location, and site ids based on the user's preferred device
            $device = Auth::user()->preferredDevice ?? null;
            $location = $device->location ?? null;
            
            //If the location exists then set the pagination page to be where the device is located
            if ($location != null)
                $request->merge(['page' => $device->dashPageNum(4)]);
            $site_id = $location->site_id ?? 0;
            $location_id = $location->id ?? 0;
            $device_id = $device->id ?? 0;
        }
        else
        {
            //Get the active site, location, and device ids
            $site_id = $request->site_id ?? 0;
            $location_id = $request->location_id ?? 0;
            $device_id = $request->device_id ?? 0;
        }
    
        //Get all sites with the selected site first
        $sites = Site::select('id', 'name')
            ->orderByRaw("id = ? DESC", $site_id)
            ->orderBy('name', 'ASC')
            ->get();
        //Get all locations for the selected site with the selected location first
        $locations = Location::select('id', 'name', 'site_id')
            ->where('site_id', '=', $sites[0]->id ?? 0)
            ->orderByRaw("id = ? DESC", $location_id)
            ->orderBy('name', 'ASC')
            ->get();
        //Get all devices for the selected location
        $devices = Device::publicDashData()
            ->where('location_id', '=', $locations[0]->id ?? 0)
            ->orderBy('name', 'ASC')
            ->paginate(4);
    
        //Get the active device
        $active_device = $devices->where('id', $device_id)->first();
        //Set the active device to the first device in $devices if it is not empty and the original active device wasn't found
        if (!$devices->isEmpty() && $active_device == null)
            $active_device = $devices[0];
    
        //Store the active site, location, and device in a collection
        $active_data = collect(['device' => $active_device, 'location' => $locations[0] ?? null, 'site' => $sites[0] ?? null]);
    
        //Use the device_list.blade.php to generate the device table html
        $html_device_table = view('dashboard.device_list', ['devices' => $devices, 'active_data' => $active_data])->render();
        
        if (\Request::ajax())
            return response()->json([ 'active_data' => $active_data, 'devices' => $devices, 'locations' => $locations,
                'sites' => $sites, 'html_device_table' => $html_device_table ]);
        else
            return view('dashboard.index', [ 'active_data' => $active_data, 'devices' => $devices,
                'locations' => $locations, 'sites' => $sites ]);
    }
    
    /**
     * Show the development layouts for dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dev_layout()
    {
        return view('dashboard.dev_layout');
    }
}
