<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function homePeminjam()
    {
         return view('peminjam.home');
    }

    // peminjam
    public function bookingPeminjam()
    {
        $lapangan = Lapangan::all();
        $booking = Booking::with('lapangan')->get();
        return view('peminjam.booking-page', compact('booking','lapangan'));
    }

    // admin
    public function bookingAdmin()
    {
        $lapangan = Lapangan::all();
        $booking = Booking::with('lapangan')->get();
        return view('admin.booking.index', compact('booking','lapangan'));
    }
    
    // fetch
    public function fetchBookings()
    {
        $booking = Booking::all(['acara', 'mulai', 'akhir'])->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->acara,
                'start' => $item->mulai,
                'end' => $item->akhir,
            ];
        });
    
        return response()->json($booking);
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
            'nama' => 'required',
            'acara' => 'required',
            'mulai' => 'required|date',
            'akhir' => 'required|date|after:mulai',
            'lapangan_id' => 'required|exists:lapangans,id', 
        ]);
    
        $lapangan = Lapangan::findOrFail($request->lapangan_id);
    
        $mulai = new \DateTime($request->mulai);
        $akhir = new \DateTime($request->akhir);
        $interval = $mulai->diff($akhir);
        $jams = $interval->h + ($interval->days * 24); 
    
        $total_harga = $jams * $lapangan->harga_per_jam;
        Booking::create([
            'nama' => $request->nama,
            'acara' => $request->acara,
            'mulai' => $request->mulai,
            'akhir' => $request->akhir,
            'lapangan_id' => $request->lapangan_id,
            'harga_per_jam' => $lapangan->harga_per_jam,
            'total_harga' => $total_harga,
        ]);
    
        return redirect()->route('booking-page')->with('success', 'Booking berhasil ditambahkan!');
    }

    public function storeBookingAdmin(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'acara' => 'required',
            'mulai' => 'required|date',
            'akhir' => 'required|date|after:mulai',
            'lapangan_id' => 'required|exists:lapangans,id', 
        ]);
    
        $lapangan = Lapangan::findOrFail($request->lapangan_id);
    
        $mulai = new \DateTime($request->mulai);
        $akhir = new \DateTime($request->akhir);
        $interval = $mulai->diff($akhir);
        $jams = $interval->h + ($interval->days * 24); 
    
        $total_harga = $jams * $lapangan->harga_per_jam;

        Booking::create([
            'nama' => $request->nama,
            'acara' => $request->acara,
            'mulai' => $request->mulai,
            'akhir' => $request->akhir,
            'lapangan_id' => $request->lapangan_id,
            'harga_per_jam' => $lapangan->harga_per_jam,
            'total_harga' => $total_harga,
        ]);
    
        return redirect()->route('booking-admin')->with('success', 'Booking berhasil ditambahkan!');
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateBooking(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'acara' => 'required',
            'mulai' => 'required|date',
            'akhir' => 'required|date|after:mulai',
            'lapangan_id' => 'required|exists:lapangans,id',
        ]);

        $lapangan = Lapangan::findOrFail($request->lapangan_id);

        $mulai = new \DateTime($request->mulai);
        $akhir = new \DateTime($request->akhir);
        $interval = $mulai->diff($akhir);
        $jams = $interval->h + ($interval->days * 24);

        $total_harga = $jams * $lapangan->harga_per_jam;

        $booking = Booking::findOrFail($id);
        $booking->update([
            'nama' => $request->nama,
            'acara' => $request->acara,
            'mulai' => $request->mulai,
            'akhir' => $request->akhir,
            'lapangan_id' => $request->lapangan_id,
            'harga_per_jam' => $lapangan->harga_per_jam,
            'total_harga' => $total_harga,
        ]);

        return redirect()->route('booking-admin')->with('success', 'Booking berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function destroyBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('booking-admin')->with('success', 'Booking berhasil dihapus!');
    }


}
