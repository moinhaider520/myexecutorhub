@extends('layouts.master')

@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 box-col-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Send Notification</h4>
                                <span>Choose the recipient type, enter a title, and message for the notification.</span>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.notifications.send') }}" method="POST">
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
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="Enter notification title" required>
                                        @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="message" class="form-label">Notification Message</label>
                                        <textarea name="message" id="message" class="form-control" rows="4" placeholder="Enter your notification message here" required>{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Send Notification</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@endsection
