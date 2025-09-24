@extends('layouts.master')

@section('content')

    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-2">
                        <h2 class="mb-4">Knowledgebase Entry Example</h2>
                        <p>Title: Executor Hub Logo Files</p>
                        <p>Body Copy:</p>
                        <p>We’ve provided official Executor Hub logos for you to use in your emails, newsletters,
                            presentations, and social posts. Using the official logo ensures a consistent and professional
                            brand presence.</p>
                        <p>Downloads Available:</p>
                        <p>• PNG (transparent)</p>
                        <div>
                            <center>
                                <img class="img-fluid" src="{{ asset('assets/frontend/images/logo-white.png') }}" alt=""
                                    style="width:250px;">

                            </center>
                            <center>
                                <a href="{{ asset('assets/frontend/images/logo-white.png') }}" download="logo-white.png"
                                    class="btn btn-primary mt-2 text-center">
                                    Download Image
                                </a>
                            </center>
                            <br />
                        </div>


                        <p>👉 Please use the logo exactly as provided — do not stretch, change colours, or crop it.</p>
                        <p>💡 Bonus Tip: If you also create a small “Powered by Executor Hub” badge, partners can drop it at
                            the bottom of their own materials — subtle but powerful brand awareness.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts for Document Reminders -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

@endsection