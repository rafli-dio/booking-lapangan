<!DOCTYPE html>
<html>
<head>
    <title>Booking Lapangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js'></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
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
                            <th>Name</th>
                            <th>Title</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Price/Day</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->title }}</td>
                            <td>{{ $booking->start }}</td>
                            <td>{{ $booking->end }}</td>
                            <td>Rp {{ number_format($booking->price_per_day, 2) }}</td>
                            <td>Rp {{ number_format($booking->total_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Booking Button -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#bookingModal">Add Booking</button>

        <!-- Booking Modal -->
        <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookingModalLabel">Create Booking</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="bookingForm" method="POST" action="{{ route('storeBooking') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="price_per_day" class="form-label">Price/Day</label>
                                <input type="number" class="form-control" id="price_per_day" name="price_per_day" required>
                            </div>
                            <div class="mb-3">
                                <label for="start" class="form-label">Start</label>
                                <input type="datetime-local" class="form-control" id="start" name="start" required>
                            </div>
                            <div class="mb-3">
                                <label for="end" class="form-label">End</label>
                                <input type="datetime-local" class="form-control" id="end" name="end" required>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/api/bookings', 
            selectable: true,
            editable: true,
            select: function(info) {
                $('#start').val(info.startStr + 'T00:00');
                $('#end').val(info.startStr + 'T23:59');
                $('#bookingModal').modal('show');
            },
            eventClick: function(info) {
                alert('Event: ' + info.event.title + '\nStart: ' + info.event.start + '\nEnd: ' + info.event.end);
            }
        });

            calendar.render();

            // Handle Form Submission
            $('#bookingForm').on('submit', function(e) {
                let formData = $(this).serialize();
                $.post('/bookings', formData).done(function() {
                    $('#bookingModal').modal('hide');
                    calendar.refetchEvents();
                });
            });
        });
    </script>
</body>
</html>
