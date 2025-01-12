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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#TaskModal">
                  Add Task
                </button>
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

<!-- ADD VOICE NOTE MODAL -->
<div class="modal fade" id="TaskModal" tabindex="-1" role="dialog" aria-labelledby="TaskModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TaskModalLabel">Add Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="TaskForm" action="{{ route('partner.voice_notes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="start_date">Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
          </div>
          <div class="form-group">
            <label for="voice-note">Task Title</label>
            <input type="text" class="form-control" name="title" required>
          </div>
          <div class="form-group">
            <label for="voice-note">Description</label>
            <textarea class="form-control" name="description"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Task</button>
        </div>
      </form>
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

    var events = @json($Tasks);

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: events.map(note => ({
        title: 'Task Calendar',
        start: note.start_date,
        extendedProps: {
          id: note.id,
          filePath: note.voice_note
        }
      })),
      eventClick: function(info) {
        info.jsEvent.preventDefault();
        alert("Task Details");
      }
    });

    calendar.render();
  });
</script>



@endsection