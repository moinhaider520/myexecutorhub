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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#voiceNoteModal">
                  Add Voice Note
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
<div class="modal fade" id="voiceNoteModal" tabindex="-1" role="dialog" aria-labelledby="voiceNoteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="voiceNoteModalLabel">Add Voice Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="voiceNoteForm" action="{{ route('partner.voice_notes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="start_date">Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
          </div>
          <div class="form-group">
            <label for="voice-note">Voice Note</label>
            <br />
            <button type="button" id="start-recording" class="btn btn-secondary">Start Recording</button>
            <button type="button" id="stop-recording" class="btn btn-secondary" disabled>Stop Recording</button>

            <audio id="audio-playback" controls></audio>
            <input type="hidden" id="audio-blob" name="audio-blob">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Note</button>
        </div>
      </form>
    </div>
  </div>
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
        <form id="delete-voice-note-form" action="" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

<script>
  let mediaRecorder;
  let audioChunks = [];

  document.getElementById('start-recording').addEventListener('click', async () => {
    const stream = await navigator.mediaDevices.getUserMedia({
      audio: true
    });
    mediaRecorder = new MediaRecorder(stream);
    mediaRecorder.start();
    audioChunks = [];

    mediaRecorder.addEventListener('dataavailable', event => {
      audioChunks.push(event.data);
    });

    mediaRecorder.addEventListener('stop', () => {
      const audioBlob = new Blob(audioChunks, {
        type: 'audio/wav'
      });
      const audioUrl = URL.createObjectURL(audioBlob);
      const audio = document.getElementById('audio-playback');
      audio.src = audioUrl;

      const reader = new FileReader();
      reader.readAsDataURL(audioBlob);
      reader.onloadend = () => {
        document.getElementById('audio-blob').value = reader.result;
      };
    });

    document.getElementById('start-recording').disabled = true;
    document.getElementById('stop-recording').disabled = false;
  });

  document.getElementById('stop-recording').addEventListener('click', () => {
    mediaRecorder.stop();
    document.getElementById('start-recording').disabled = false;
    document.getElementById('stop-recording').disabled = true;
  });
</script>

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
        document.getElementById('delete-voice-note-form').action = `{{ route('partner.voice_notes.destroy', '') }}/${event.id}`;
        $('#playVoiceNoteModal').modal('show');
      }

    });

    calendar.render();
  });
</script>



@endsection