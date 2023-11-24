<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'seat_id' => [
                'required', 'exists:seats,id',
                Rule::unique('bookings')->where(function ($query) {
                    return $query->where('seat_id', $this->input('seat_id'))
                        ->where('from_station_id', $this->input('from_station_id'))
                        ->where('to_station_id', $this->input('to_station_id'))
                        ->where('trip_id', $this->input('trip_id'));
                }),
            ],
            'from_station_id' => 'required|exists:stations,id',
            'to_station_id' => 'required|exists:stations,id',
            'trip_id' => 'required|exists:trips,id'
        ];
    }
}
