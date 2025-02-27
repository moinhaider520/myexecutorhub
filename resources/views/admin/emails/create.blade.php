@extends('layouts.master')

@section('content')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<div class="page-body">
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 box-col-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Send Email</h4>
                                <span>Choose the recipient type, enter a subject, and body for the email.</span>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.emails.send') }}" method="POST" id="email-form">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="recipient_type" class="form-label">Send to</label>
                                        <select name="recipient_type" id="recipient_type" class="form-select" required>
                                            <option value="" disabled selected>Select recipient type</option>
                                            <option value="customers">Customers</option>
                                            <option value="partners">Partners</option>
                                            <option value="customers_and_partners">Customers and Partners</option>
                                        </select>
                                        @error('recipient_type')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="title" class="form-label">Subject</label>
                                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter Subject" required>
                                        @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="message" class="form-label">Email Body</label>
                                        <div id="quill-editor" style="height: 200px;"></div>

                                        <!-- Hidden Textarea for Form Submission -->
                                        <textarea name="message" id="message" class="form-control" rows="4" hidden>{{ old('message') }}</textarea>
                                        @error('message')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Send Email</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Type your email body here...'
    });

    // Set initial content from old value, if available
    var oldMessage = document.getElementById('message').value;
    if (oldMessage) {
        quill.root.innerHTML = oldMessage;
    }

    // Sync Quill content to textarea on form submit
    document.getElementById('email-form').addEventListener('submit', function(event) {
        var messageContent = quill.root.innerHTML.trim();
        
        // Check if message content is empty
        if (messageContent === "") {
            alert('Please enter a message before submitting.');
            event.preventDefault(); // Stop form submission
        } else {
            document.getElementById('message').value = messageContent; // Update hidden textarea
        }
    });
</script>
@endsection
