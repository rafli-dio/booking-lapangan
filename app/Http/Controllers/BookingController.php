<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function home()
     {
         return view('home');
     }

    public function index()
    {
        $bookings = Booking::all();
        return view('booking-page', compact('bookings'));
    }

    public function fetchBookings()
    {
        $bookings = Booking::all(['id', 'title', 'start', 'end']);
        return response()->json($bookings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'price_per_day' => 'required|numeric',
        ]);

        $start = new \DateTime($request->start);
        $end = new \DateTime($request->end);
        $interval = $start->diff($end);
        $days = $interval->days + 1; 

        $totalPrice = $days * $request->price_per_day;

        Booking::create(array_merge($request->all(), ['total_price' => $totalPrice]));

        return response()->json(['success' => 'Event created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'price_per_day' => 'required|numeric',
        ]);

        $start = new \DateTime($request->start);
        $end = new \DateTime($request->end);
        $interval = $start->diff($end);
        $days = $interval->days + 1; 

        $totalPrice = $days * $request->price_per_day;

        $booking = Booking::findOrFail($id);
        $booking->update(array_merge($request->all(), ['total_price' => $totalPrice]));

        return response()->json(['success' => 'Event updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();
        return response()->json(['success' => 'Event deleted successfully.']);
    }
}
