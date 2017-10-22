<?php 

namespace App\Http\Controllers;

use App\Sensor;
use App\DataTables\SensorDataTable;
use Illuminate\Http\Request;
use Validator;
use Charts;

class SensorController extends Controller 
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Display a listing of the resource.
    *
    * @param  SensorDataTable   $dataTable
    * @return Response
    */
    public function index(SensorDataTable $dataTable)
    {
        return $dataTable->render('sensor.index');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('sensor.create');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param Request $request
    * @return Response
    */
    public function store(Request $request)
    {
        request()->validate([
            'device_id' => 'required|integer|exists:devices,id',
            'name' => 'required|string|max:190',
            'type' => 'required|string|max:190'
        ]);

        $query = Sensor::create($request->all());

        return redirect()->route('sensor.show', $query->id)
            ->with('success', 'Sensor created successfully');
    }

    /**
    * Display the specified resource.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function show(Request $request, $id)
    {
        $sensor = Sensor::findOrFail($id);
        
        $sensordata = $sensor->data()->paginate(25);
        
        $chart = Charts::create('line', 'highcharts')
            ->title($sensor->name)
            ->elementLabel($sensor->type)
            ->labels($sensordata->pluck('created_at'))
            ->values($sensordata->pluck('value'))
            ->responsive(true);
            
        // $chart = Charts::database($sensor->data(), 'bar', 'highcharts')
        //     ->elementLabel("Total")
        //     ->responsive(true)
        //     ->groupByHour();
        
        return view('sensor.show', [ 'sensor' => $sensor, 'sensordata' => $sensordata, 'chart' => $chart ]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function edit(Request $request, $id)
    {
        $sensor = Sensor::findOrFail($id);
        
        return view('sensor.edit', [ 'sensor' => $sensor ]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request, $id)
    {
        request()->validate([
            'device_id' => 'required|integer|exists:devices,id',
            'name' => 'required|string|max:190',
            'type' => 'required|string|max:190'
        ]);
        $query = Sensor::findOrFail($id)->update($request->all());
        return redirect()->route('sensor.show', $id)
            ->with('success', 'Sensor updated successfully');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        Sensor::findOrFail($id)->delete();
        return redirect()->route('sensor.index')
            ->with('success','Sensor deleted successfully');
    }

}