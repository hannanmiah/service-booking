<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // fetch bookings
        $bookings = $request->user()->bookings()->with('service')->latest()->get();
        // return resource collection
        return BookingResource::collection($bookings);
    }

    public function show(Booking $booking)
    {
        // load relations
        $booking->load('service', 'user');
        // return response
        return BookingResource::make($booking);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // create booking
        $booking = $request->user()->bookings()->create([
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
            'status' => 'pending',
        ]);
        // return resource
        return response()->json(BookingResource::make($booking), 201);
    }

    public function getAllBookings()
    {
        $query = Booking::query();
        // filter by status
        $query->when(request('status'), function ($query, $status) {
            $query->where('status', $status);
        });
        // filter by date
        $query->when(request('date'), function ($query, $date) {
            $query->where('booking_date', $date);
        });
        // filter by service
        $query->when(request('service'), function ($query, $service) {
            $query->where('service_id', $service);
        });
        // filter by user
        $query->when(request('user'), function ($query, $user) {
            $query->where('user_id', $user);
        });
        // fetch results
        $bookings = $query->with(['user', 'service'])->get();
        // return resource collection
        return BookingResource::collection($bookings);
    }
}