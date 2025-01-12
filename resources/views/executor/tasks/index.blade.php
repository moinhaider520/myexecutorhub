@extends('layouts.master')

@section('content')

<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Tasks</h4>
              </div>
              <div class="card-body">
                <div class="calendar-default" id="calendar-container">
                  <div id="calendar"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>

<!-- Modal for showing task details -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="taskModalLabel">Task Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>Title: </strong><span id="taskTitle"></span></p>
        <p><strong>Description: </strong><span id="taskDescription"></span></p>
        <p><strong>Date: </strong><span id="taskDate"></span></p>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var events = @json($Tasks).map(note => ({
    title: note.title, 
    start: note.date, 
    extendedProps: {
      id: note.id,
      description: note.description,
      date: note.date,
    }
  }));

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    events: events,
    eventClick: function(info) {
      info.jsEvent.preventDefault(); 
      var task = info.event.extendedProps;     
      $('#taskTitle').text(info.event.title);  
      $('#taskDescription').text(task.description);  
      $('#taskDate').text(task.date);  

      // Show the modal
      $('#taskModal').modal('show');
    }
  });

  calendar.render();
});

</script>

@endsection
