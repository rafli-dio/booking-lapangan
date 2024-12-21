<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Buat Booking</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm" method="POST" action="{{ route('store-booking-admin') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="acara" class="form-label">Acara</label>
                        <input type="text" class="form-control" id="acara" name="acara" required>
                    </div>
                    <div class="mb-3">
                        <label for="lapangan_id" class="form-label">Lapangan</label>
                        <select class="form-control" id="lapangan_id" name="lapangan_id" required>
                            @foreach ($lapangan as $lapangans)
                            <option value="{{ $lapangans->id }}">{{ $lapangans->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mulai" class="form-label">Mulai</label>
                        <input type="datetime-local" class="form-control" id="mulai" name="mulai" required>
                    </div>
                    <div class="mb-3">
                        <label for="akhir" class="form-label">Akhir</label>
                        <input type="datetime-local" class="form-control" id="akhir" name="akhir" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Event Detail Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Detail Event</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Acara:</strong> <span id="eventTitle"></span></p>
                <p><strong>Mulai:</strong> <span id="eventStart"></span></p>
                <p><strong>Akhir:</strong> <span id="eventEnd"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@foreach($booking as $bookings)
<div class="modal fade" id="editModal{{ $bookings->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('updateBooking', $bookings->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit bookings</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $bookings->nama }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="acara" class="form-label">Acara</label>
                                    <input type="text" class="form-control" id="acara" name="acara" value="{{ $bookings->acara }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="lapangan_id" class="form-label">Lapangan</label>
                                    <select class="form-control" id="lapangan_id" name="lapangan_id" required>
                                        @foreach($lapangan as $lapangans)
                                        <option value="{{ $lapangans->id }}" {{ $lapangans->id == $bookings->lapangan_id ? 'selected' : '' }}>
                                            {{ $lapangans->nama }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="mulai" class="form-label">Mulai</label>
                                    <input type="datetime-local" class="form-control" id="mulai" name="mulai" value="{{ date('Y-m-d\TH:i', strtotime($bookings->mulai)) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="akhir" class="form-label">Akhir</label>
                                    <input type="datetime-local" class="form-control" id="akhir" name="akhir" value="{{ date('Y-m-d\TH:i', strtotime($bookings->akhir)) }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Modal Edit -->
            @endforeach
        </tbody>
    </table>
</div>
@extends('component.app')
@section('title-header','Admin')
@section('title','Booking')
@section('title-user','Admin')
@section('main')

<div class="col-12 col-md-6 col-lg-12">
    <div class="card mb-4">
        <div class="card-body">
            <div id='calendar'></div>
            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#bookingModal">Tambah Booking</button>
            <table id="bookingTable" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center; width: 5%;">No</th>
                        <th style="text-align: center;">Nama</th>
                        <th style="text-align: center;">Acara</th>
                        <th style="text-align: center;">Mulai</th>
                        <th style="text-align: center;">Akhir</th>
                        <th style="text-align: center;">Lapangan</th>
                        <th style="text-align: center;">Harga Per Jam</th>
                        <th style="text-align: center;">Total Harga</th>
                        <th style="text-align: center; width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($booking as $index => $bookings)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $bookings->nama }}</td>
                        <td>{{ $bookings->acara }}</td>
                        <td>{{ $bookings->mulai }}</td>
                        <td>{{ $bookings->akhir }}</td>
                        <td>{{ $bookings->lapangan->nama }}</td>
                        <td>Rp {{ number_format($bookings->lapangan->harga_per_jam, 2) }}</td>
                        <td>Rp {{ number_format($bookings->total_harga, 2) }}</td>
                        <td class="text-center">
                            <!-- Tombol Edit -->
                            <button class="btn btn-warning btn-sm" style="width: 100px;" data-toggle="modal" data-target="#editModal{{ $bookings->id }}">Edit</button>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('destroyBooking', $bookings->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" style="width: 100px;" onclick="return confirm('Yakin ingin menghapus booking ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data booking</td>
                    </tr>
                    @endforelse
                </tbody>
        </table>

        </div>
    </div>    
</div>
@endsection

