<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Sensor extends Model 
{
    use LogsActivity;

    protected $table = 'sensors';

    /**
     * Update the updated_at and created_at timestamps?
     *
     * @var array
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('device_id', 'name', 'type');

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = array('id', 'device_id', 'name', 'type');

    /**
     * The attributes to log in the Activity Log
     *
     * @var array
     */
    protected static $logAttributes = array('id', 'device_id', 'name', 'type');

    /**
     * Only log those that have actually changed after the update.
     *
     * @var array
     */
    protected static $logOnlyDirty = true;

    /**
     * Get the device associated with the sensor.
     */
    public function device()
    {
        return $this->belongsTo('App\Device');
    }

    /**
     * Get the sensor data associated with the sensor.
     */
    public function data()
    {
        return $this->hasMany('App\SensorData')->orderBy('id', 'DESC');
    }
    
    /**
     * Get the latest sensor data entry associated with the sensor.
     */
    public function getLatestDataAttribute()
    {
        return $this->hasOne('App\SensorData')->latest()->first() ?? (object)[];
    }
    
    /**
     * Get the last hour's sensor data averaged by the minute for the sensor.
     */
    public function getLastHourMinutelyAvgDataAttribute()
    {
        return $this->hasMany('App\SensorData')
            ->selectRaw("CONCAT(DATE_FORMAT(created_at, '%Y-%m-%d %H:%i'), ':00') AS date, AVG(value) AS value")
            ->whereRaw("created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)")
            ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i')"))
            ->get();
    }
    
    /**
     * Get the last day's sensor data averaged hourly for the sensor.
     */
    public function getLastDayHourlyAvgDataAttribute()
    {
        // SELECT CONCAT(DATE_FORMAT(created_at, '%Y-%m-%d %H'), ':00:00') AS date, AVG(value) As value FROM sensor_data WHERE sensor_id = 20 AND created_at > DATE_SUB(NOW(), INTERVAL 1 DAY) GROUP BY DATE_FORMAT(created_at, '%Y-%m-%d %H')
        return $this->hasMany('App\SensorData')
            ->selectRaw("CONCAT(DATE_FORMAT(created_at, '%Y-%m-%d %H'), ':00:00') AS date, AVG(value) AS value")
            ->whereRaw("created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)")
            ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H')"))
            ->get();
    }
    
    /**
     * Get the last weeks's sensor data averaged daily for the sensor.
     */
    public function getLastWeekDailyAvgDataAttribute()
    {
        return $this->hasMany('App\SensorData')
            ->selectRaw("CONCAT(DATE_FORMAT(created_at, '%Y-%m-%d '), '00:00:00') AS date, AVG(value) AS value")
            ->whereRaw("created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)")
            ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d ')"))
            ->get();
    }
    
    /**
     * Get the last months's sensor data averaged daily for the sensor.
     */
    public function getLastMonthDailyAvgDataAttribute()
    {
        return $this->hasMany('App\SensorData')
            ->selectRaw("CONCAT(DATE_FORMAT(created_at, '%Y-%m-%d'), ' 00:00:00') AS date, AVG(value) AS value")
            ->whereRaw("created_at > DATE_SUB(NOW(), INTERVAL 30 DAY)")
            ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d ')"))
            ->get();
    }
    
    /**
     * Get the last year's sensor data averaged monthly for the sensor.
     */
    public function getLastYearMonthlyAvgDataAttribute()
    {
        return $this->hasMany('App\SensorData')
            ->selectRaw("CONCAT(DATE_FORMAT(created_at, '%Y-%m'), '-00 00:00:00') AS date, AVG(value) AS value")
            ->whereRaw("created_at > DATE_SUB(NOW(), INTERVAL 1 YEAR)")
            ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();
    }
}