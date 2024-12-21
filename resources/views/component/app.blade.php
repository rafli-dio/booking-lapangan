<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Booking Lapangan</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Libraries -->
  <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- Template CSS -->
  <link href="{{asset('/assets/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('/assets/css/components.css')}}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <!-- navbar -->
      @include('component.navbar')
      <!-- end navbar -->
      <!-- sidebar -->
      @include('component.sidebar')
      <!-- end sidebar -->
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>@yield('title')</h1>
          </div>
          @yield('main')
        </section>
      </div>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js'></script>
  <script src="{{asset('/assets/js/stisla.js')}}"></script>
  <!-- Template JS File -->
  <script src="{{asset('/assets/js/scripts.js')}}"></script>
  <script src="{{asset('/assets/js/custom.js')}}"></script>
  <script>
      $(document).ready(function() {
          $('#bookingTable').DataTable({
              language: {
                  search: "Cari:",
                  lengthMenu: "Tampilkan _MENU_ entri",
                  info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                  paginate: {
                      previous: "Sebelumnya",
                      next: "Berikutnya"
                  }
              },
              pageLength: 5,
              lengthMenu: [5, 10, 25, 50],
              order: [[2, "asc"]] ,
              scrollX: true 
          });
      });
  </script>
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
  <!-- sweatalert -->

</body>
</html>
