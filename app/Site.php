<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Site extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
    
    public $timestamps = false;
    
    /**
     * Get the locations for the site.
     */
    public function locations()
    {
        return $this->hasMany('App\Location');
    }
    
    /**
     * Get the devices for the site.
     */
    public function devices()
    {
        return $this->hasManyThrough('App\Device', 'App\Location', 'device_id', 'location_id', 'id');
    }
    
    /**
     * Get all the sites starting with the site with the id supplied and the rest sorted by their id in descending order
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function orderedSitesBy($id)
    {
        $sites = self::query()->select(['id', 'name'])
                                ->orderByRaw(DB::raw("(id = " . $id . ") DESC"))
                                ->get();
        return $sites;
    }
    
    /**
     * Create a new site and return its id
     *
     * @param string $name
     * @return int $id
     */
    public function createSite($name)
    {
        $site = new Site;
        $site->name = $name;
        $site->save();
        
        return $site->id;
    }
}