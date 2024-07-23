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
                <h4>Voice Notes</h4>
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

<!-- PLAY VOICE NOTE MODAL -->
<!-- Modal -->
<div class="modal fade" id="playVoiceNoteModal" tabindex="-1" role="dialog" aria-labelledby="playVoiceNoteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="playVoiceNoteModalLabel">Voice Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <audio id="modal-audio-play" controls></audio>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

    var events = @json($voiceNotes);

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: events.map(note => ({
        title: 'Voice Note',
        start: note.start_date,
        extendedProps: {
          id: note.id,
          filePath: note.voice_note
        }
      })),
      eventClick: function(info) {
        info.jsEvent.preventDefault();
        var event = info.event.extendedProps;
        document.getElementById('modal-audio-play').src = '/storage/' + event.filePath;
        $('#playVoiceNoteModal').modal('show');
      }
    });

    calendar.render();
  });
</script>

@endsection
