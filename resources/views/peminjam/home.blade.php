<!DOCTYPE html>
<html>
<head>
    <title>Booking Lapangan Karanganyar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js'></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Booking Lapangan</h1>
        
        <div class="text-center mb-4">
            <a href="{{route('booking-page')}}" class="btn btn-primary btn-lg">Booking Lapangan</a>
        </div>
        
        <!-- Calendar -->
        <div id="calendar"></div>
    </div>

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
                // Isi data event ke dalam modal
                $('#eventTitle').text(info.event.title);
                $('#eventStart').text(new Date(info.event.start).toLocaleString());
                $('#eventEnd').text(new Date(info.event.end).toLocaleString());
                $('#eventModal').modal('show'); // Tampilkan modal
            }
        });

        calendar.render();
    });
</script>
</body>
</html>
