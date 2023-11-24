<?php

namespace App\Repositories;

use App\Models\Booking;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\BookingRepository;

/**
 * Class BookingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BookingRepositoryEloquent extends BaseRepository implements BookingRepository
{
    function search($search)
    {
        return $this->model->search($search);
    }

    function searchByUser($userId)
    {
        return $this->model->byUser($userId);
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Booking::class;
    }

    public function createBooking(array $data)
    {
        return $this->create($data);
    }

    public function updateBooking(array $data, $id)
    {
        $booking = $this->find($id);
        if ($booking) {
            $this->update($data, $id);
            return $this->find($id);
        }
        return null;
    }

    public function softDeleteBooking($id)
    {
        $booking = $this->find($id);
        if ($booking) {
            return $booking->delete(); // Soft delete the booking
        }
        return false;
    }

    // Retrieve all bookings with user, trip , fromStation , toStation and seat
    public function getAllBookings()
    {
        return $this->model->select('user_id', 'trip_id', 'from_station_id', 'to_station_id', 'seat_id');
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
