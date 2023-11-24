<?php

namespace App\Repositories;

use App\Models\CrossoverStation;
use App\Models\Trip;
use App\Repositories\Interfaces\TripRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class TripRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TripRepositoryEloquent extends BaseRepository implements TripRepository
{

    function search($search)
    {
        return $this->model->search($search);
    }

    function searchByStartEndStation($start, $end)
    {
        return $this->model->byStartEndStation($start, $end);
    }
    /**
     * Specify Model class name
     *
     * @return string
     */

    public function model()
    {
        return Trip::class;
    }

    // Retrieve all trips with name , from_station , to_station and bus
    public function getAllTrips()
    {
        return $this->model->select('id', 'name', 'from_station_id', 'to_station_id', 'bus_id');
    }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
