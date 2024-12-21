<!DOCTYPE html>
<html>
<head>
    <title>Booking Lapangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Pastikan jQuery dimuat terlebih dahulu -->
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Booking Lapangan</h1>

        <!-- Booking Summary Table -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Booking Summary</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Acara</th>
                            <th>Mulai</th>
                            <th>Akhir</th>
                            <th>Lapangan</th>
                            <th>Harga Per Jam</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking as $index => $bookings)
                        <tr>
                            <td>{{ $bookings->nama }}</td>
                            <td>{{ $bookings->acara }}</td>
                            <td>{{ $bookings->mulai }}</td>
                            <td>{{ $bookings->akhir }}</td>
                            <td>{{ $bookings->lapangan->nama }}</td>
                            <td>Rp {{ number_format($bookings->lapangan->harga_per_jam, 2) }}</td>
                            <td>Rp {{ number_format($bookings->total_harga, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Booking Button -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#bookingModal">Tambah Booking</button>

        <!-- Booking Modal -->
        <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookingModalLabel">Buat Booking</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="bookingForm" method="POST" action="{{ route('storeBooking') }}">
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
        
        <!-- Calendar -->
        <div id='calendar'></div>
    </div>
    <!-- Event Detail Modal -->
        <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">Detail Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Acara:</strong> <span id="eventTitle"></span></p>
                        <p><strong>Mulai:</strong> <span id="eventStart"></span></p>
                        <p><strong>Akhir:</strong> <span id="eventEnd"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/api/booking',
            selectable: true,
            editable: true,
            select: function(info) {
                $('#mulai').val(info.startStr + 'T00:00');
                $('#akhir').val(info.startStr + 'T23:59');
                $('#bookingModal').modal('show');
            },
            eventClick: function(info) {
                $('#eventTitle').text(info.event.title);
                $('#eventStart').text(new Date(info.event.start).toLocaleString());
                $('#eventEnd').text(new Date(info.event.end).toLocaleString());
                $('#eventModal').modal('show'); 
            }
        });
        calendar.render();
    });
    </script>
</body>
</html>
