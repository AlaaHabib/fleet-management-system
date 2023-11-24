<?php

namespace App\Http\Controllers;

use App\Constants\FleetManagementConstants;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\RecordTripRequest;
use App\Http\Resources\TripResource;
use App\Http\Responses\Response;
use App\Models\Station;
use App\Repositories\BookingRepositoryEloquent;
use App\Repositories\TripRepositoryEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

/**
 * @group Trips
 * APIs for managing Trips
 * @OAS\SecurityScheme(
 *      securityScheme="bearer_token",
 *      type="http",
 *      scheme="bearer"
 * )
 */
class TripController extends Controller
{
    public TripRepositoryEloquent $tripRepository;
    public BookingRepositoryEloquent $bookingRepository;

    public function __construct(TripRepositoryEloquent $tripRepository, BookingRepositoryEloquent $bookingRepository)
    {
        $this->tripRepository = $tripRepository;
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * Get all trips
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/api/v1/trips",
     *     summary="Get trips with available seats",
     *     security={{"bearerAuth":{}}},
     *     tags={"Trips"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Limit the number of results",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *    @OA\Parameter(
     *          name="page",
     *          description="page",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *    @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(
     *         name="start_station",
     *         in="query",
     *         description="Start Station Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Parameter(
     *         name="end_station",
     *         in="query",
     *         description="End Station Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *          name="Locale",
     *          description="Locale",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful",
     *     @OA\JsonContent(
     *              type="object",
     *               @OA\Property(property="is_successful", type="boolean", example=true),
     *               @OA\Property(property="message", type="string", description="string"),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="integer",
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="start_station_id", type="integer"),
     *                  @OA\Property(property="start_station", type="string"),
     *                  @OA\Property(property="end_station_id", type="integer"),
     *                  @OA\Property(property="end_station", type="string"),
     *                  @OA\Property(property="bus_id", type="integer"),
     *                  @OA\Property(property="bus", type="string"),
     *                  @OA\Property(property="total_seats", type="integer"),
     *                  @OA\Property(property="available_seats", type="integer"),
     *                  @OA\Property(property="seats", type="object"),
     *              ),
     *               @OA\Property(property="errors", type="object"),
     *               @OA\Property(property="response_code", type="string", description="Response code"),
     *          )
     *      ),
     *     @OA\Property(property="is_successful", type="boolean", example=true),
     *     @OA\Property(type="string",description="message",property="message" , example="List of trips Have Been Retrieved Successfully."),
     *     @OA\Property(type="object",description="errors",property="errors" , example=""),
     *     @OA\Property(type="string",description="response_code",property="response_code" , example="TRIP_2001"),
     *    ),
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', null);
        $start_station =  $request->query('start_station');
        $end_station =  $request->query('end_station');
        if (Station::where('id', $start_station)->first() == null || Station::where('name', $end_station)->first() == null)
            return Response::create()
                ->setStatusCode(ResponseStatus::HTTP_NOT_FOUND)
                ->setMessage(__(FleetManagementConstants::RESPONSE_CODES_MESSAGES[FleetManagementConstants::TRIP_2002]))
                ->setResponseCode(FleetManagementConstants::TRIP_2002)
                ->failure();
        $query = $this->tripRepository;

        $query = $query->searchByStartEndStation($start_station, $end_station);

        if ($request->has('search')) {
            $query = $query->search($request->search);
        }

        // Paginate the results
        $result = $query->orderBy('created_at', 'asc')->paginate($limit);

        $result = new TripResource($result);
        $result = $result->response()->getData(true);

        return Response::create()
            ->setData($result)
            ->setStatusCode(ResponseStatus::HTTP_OK)
            ->setMessage(__(FleetManagementConstants::RESPONSE_CODES_MESSAGES[FleetManagementConstants::TRIP_2001]))
            ->setResponseCode(FleetManagementConstants::TRIP_2001)
            ->success();
    }

    /**
     * @OA\Post(
     *     path="/api/v1/booking",
     *     summary="Booking a seat",
     *     security={{"bearerAuth":{}}},
     *     tags={"Booking"},
     *     @OA\Parameter(
     *          name="Locale",
     *          description="Locale",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="seat_id", type="integer"),
     *             @OA\Property(property="from_station_id", type="integer"),
     *             @OA\Property(property="to_station_id", type="integer"),
     *             @OA\Property(property="trip_id", type="integer"),
     *         )
     *     ),
     *      @OA\Response(
     *         response="200",
     *         description="Successful",
     *     @OA\JsonContent(
     *              type="object",
     *               @OA\Property(property="is_successful", type="boolean", example=true),
     *               @OA\Property(property="message", type="string", description="string"),
     *               @OA\Property(property="errors", type="object"),
     *               @OA\Property(property="response_code", type="string", description="Response code"),
     *      ),
     *     @OA\Property(property="is_successful", type="boolean", example=true),
     *     @OA\Property(type="string",description="message",property="message" , example="A seat Has Been Booked Successfully"),
     *     @OA\Property(type="object",description="errors",property="errors" , example=""),
     *     @OA\Property(type="string",description="response_code",property="response_code" , example="BOOKING_1001"),
     *    ),
     * )
     */
    public function booking(BookingRequest $request)
    {
        try {
            $data['user_id'] = Auth::user()->id;

            $data = $request->only(
                [
                    'seat_id',
                    'from_station_id',
                    'to_station_id',
                    'trip_id'
                ]
            );
            $this->bookingRepository->create($data);

            return Response::create()
                ->setMessage(__(FleetManagementConstants::RESPONSE_CODES_MESSAGES[FleetManagementConstants::BOOKING_1001]))
                ->setStatusCode(ResponseStatus::HTTP_CREATED)
                ->setResponseCode(FleetManagementConstants::BOOKING_1001)
                ->success();
        } catch (\Throwable $th) {
            return Response::create()
                ->setMessage($th)
                ->setStatusCode(ResponseStatus::HTTP_BAD_REQUEST)
                ->failure();
        }
    }
}
