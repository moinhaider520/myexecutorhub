@extends('layouts.master')

@section('content')
<div class="page-body">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <h3>Disclaimer</h3>
        <p>The responses provided by Executor Hub AI are not 100% correct. The information provided is backed up by other resources. It is always a good idea to verify information from multiple sources before making important decisions.</p>
      </div>
    </div>
    <div class="row g-0">
      <div class="card right-sidebar-chat">
        <div class="right-sidebar-title">
          <div class="common-space">
            <div class="chat-time">
              <div>
                <span>Executor Hub AI</span>
                <p>Online</p>
              </div>
            </div>
          </div>
        </div>
        <div class="right-sidebar-Chats">
          <div class="msger">
            <div class="msger-chat messages">
              @foreach ($messages as $message)
                <div class="msg {{ $message->role == 'user' ? 'right-msg' : 'left-msg' }}">
                  <div class="msg-bubble">
                    <div class="msg-info">
                      <div class="msg-info-name">{{ $message->role == 'user' ? 'You' : 'Executor Hub AI' }}</div>
                    </div>
                    <div class="msg-text">{{ $message->content }}</div>
                  </div>
                </div>
              @endforeach
            </div>
            <form id="form" class="msger-inputarea">
              <input class="form-control" style="width:100%;" type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
              <button id="chatbutton" class="msger-send-btn" type="submit">Send</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function () {
    $("#form").submit(function (event) {
      event.preventDefault();

      // Stop empty messages
      if ($("#message").val().trim() === '') {
        return;
      }

      // Disable form
      $("#message").prop('disabled', true);
      $("#chatbutton").prop('disabled', true);

      $.ajax({
        url: '{{ route("partner.openai.chat") }}',
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: {
          "model": "gpt-3.5-turbo",
          "content": $("#message").val()
        },
        dataType: 'json'
      }).done(function (res) {
        if (res.status === 'success') {
          // Populate sending message
          $(".messages").append('<div class="msg right-msg">' +
            '<div class="msg-bubble"><div class="msg-info"><div class="msg-info-name">You</div></div>' +
            '<div class="msg-text">' + $("#message").val() + '</div>' +
            '</div></div>');

          // Populate receiving message
          $(".messages").append('<div class="msg left-msg">' +
            '<div class="msg-bubble"><div class="msg-info"><div class="msg-info-name">Executor Hub AI</div></div>' +
            '<div class="msg-text">' + res.message + '</div>' +
            '</div></div>');
        } else {
          $(".messages").append('<div class="msg left-msg">' +
            '<div class="msg-bubble"><div class="msg-info"><div class="msg-info-name">Executor Hub AI</div></div>' +
            '<div class="msg-text">' + res.message + '</div>' +
            '</div></div>');
        }

        // Cleanup
        $("#message").val('');
        $(document).scrollTop($(document).height());

        // Enable form
        $("#message").prop('disabled', false);
        $("#chatbutton").prop('disabled', false);
      }).fail(function (xhr, status, error) {
        console.error(error);
        $(".messages").append('<div class="msg left-msg">' +
            '<div class="msg-bubble"><div class="msg-info"><div class="msg-info-name">Executor Hub AI</div></div>' +
            '<div class="msg-text">Chat GPT Limit Reached. This means too many people have used this demo this month and hit the FREE limit available. You will need to wait, sorry about that.</div>' +
            '</div></div>');

        // Enable form
        $("#message").prop('disabled', false);
        $("#chatbutton").prop('disabled', false);
      });
    });
  });
</script>

@endsection