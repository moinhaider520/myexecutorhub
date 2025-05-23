@extends('layouts.master')

@section('content')

<div class="page-body">
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 box-col-12">
        <div class="card">
          <div class="card-header">
            <h4>Tasks</h4>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#TaskModal">
              Add Task
            </button>
          </div>
          <div class="card-body">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add/Edit Task Modal -->
<div class="modal fade" id="TaskModal" tabindex="-1" role="dialog" aria-labelledby="TaskModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="TaskForm">
        @csrf
        <input type="hidden" id="task_id" name="id">
        <div class="modal-header">
          <h5 class="modal-title" id="TaskModalLabel">Add Task</h5>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Date</label>
            <input type="date" class="form-control" id="task_date" name="date" required>
          </div>
          <div class="form-group">
            <label>Time</label>
            <input type="time" class="form-control" id="task_time" name="time">
          </div>
          <div class="form-group">
            <label>Task Title</label>
            <input type="text" class="form-control" id="task_title" name="title" required>
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" id="task_description" name="description"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Task</button>
          <button type="button" id="deleteButton" class="btn btn-danger" style="display:none;"
            onclick="deleteTask()">Delete Task</button>
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
    var tasks = @json($tasks);

  // Helper function to convert 24-hour time to 12-hour format with AM/PM
  const formatTimeTo12Hour = (time24) => {
      if (!time24) return '';
      const [hour, minute] = time24.split(':');
      let h = parseInt(hour);
      let ampm = h >= 12 ? 'PM' : 'AM';
      h = h % 12;
      h = h ? h : 12;
      return `${h}:${minute} ${ampm}`;
    };

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: tasks.map(task => ({
        id: task.id,
        title: task.time ? `${formatTimeTo12Hour(task.time)} - ${task.title}` : task.title,
        start: task.date,
        start: task.time ? `${task.date}T${task.time}` : task.date,
        extendedProps: {
          description: task.description,
          time: task.time
        }
      })),
      eventClick: function(info) {
        $('#task_id').val(info.event.id);
        $('#task_date').val(info.event.start.toISOString().substring(0, 10));

        // Handle time if available
        if (info.event.extendedProps.time) {
          $('#task_time').val(info.event.extendedProps.time);
        } else {
          $('#task_time').val('');
        }

        $('#task_title').val(info.event.title);
        $('#task_description').val(info.event.extendedProps.description);
        $('#TaskModalLabel').text('Edit Task');
        $('#deleteButton').show(); // Show the delete button for editing
        $('#TaskModal').modal('show');
      }
    });

    calendar.render();

    // Reset form when modal is opened for adding new task
    $('[data-toggle="modal"][data-target="#TaskModal"]').on('click', function() {
      $('#TaskForm')[0].reset();
      $('#task_id').val('');
      $('#TaskModalLabel').text('Add Task');
      $('#deleteButton').hide();
    });

    // Add/Edit Task
    $('#TaskForm').on('submit', function(e) {
      e.preventDefault();
      let taskId = $('#task_id').val();
      let method = taskId ? 'PUT' : 'POST';
      let url = taskId ? `/customer/tasks/${taskId}` : "{{ route('customer.tasks.store') }}";

      $.ajax({
        url: url,
        method: method,
        data: $(this).serialize(),
        success: function(response) {
          $('#TaskModal').modal('hide');
          alert(response.message);
          location.reload();
        },
        error: function(xhr) {
          alert('Error: ' + xhr.responseJSON.message);
        }
      });
    });

    // Delete Task
    window.deleteTask = function() {
      let taskId = $('#task_id').val();
      if (confirm("Are you sure you want to delete this task?")) {
        $.ajax({
          url: `/customer/tasks/${taskId}`,
          method: 'DELETE',
          data: {
            _token: "{{ csrf_token() }}"
          },
          success: function(response) {
            $('#TaskModal').modal('hide');
            alert(response.message);
            location.reload();
          },
          error: function(xhr) {
            alert('Error: ' + xhr.responseJSON.message);
          }
        });
      }
    }
  });
</script>

<script>
  $(document).on('click', '.close-modal', function() {
    $('#TaskModal').modal('hide');
  });
</script>

@endsection