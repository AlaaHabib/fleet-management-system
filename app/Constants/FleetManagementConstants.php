<?php

namespace App\Constants;

class FleetManagementConstants
{
    const BOOKING_1001 = "BOOKING-1001";

    const TRIP_2001 = "TRIP-2001";
    const TRIP_2002 = "TRIP-2002";


    const AUTH_4001 = "AUTH-4001";
    const AUTH_4002 = "AUTH-4002";
    const AUTH_4003 = "AUTH-4003";

    const RESPONSE_CODES_MESSAGES = [
        self::BOOKING_1001 => 'translation.bookingSuccessfully',

        self::TRIP_2001 => 'translation.listRetrieved',
        self::TRIP_2002 => 'translation.notFound',


        self::AUTH_4001 => 'translation.authenticated',
        self::AUTH_4002 => 'translation.unauthenticated',
        self::AUTH_4003 => 'translation.logout',
    ];
}
