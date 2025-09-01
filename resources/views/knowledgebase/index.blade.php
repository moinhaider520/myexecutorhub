@extends('layouts.master')

@section('content')

    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <h2 class="p-2">Video Title: Partner Welcome</h2>
                        <video id="earningVideo" style="width:100%;height:390px;" controls>
                            <source src="{{ asset('assets/knowledgebase/video1.mp4') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h2 class="p-2">Title: How to Introduce Executor Hub to Clients</h2>
                        @if(auth()->user()->profession == "General")
                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                <source src="{{ asset('assets/knowledgebase/video2.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                        @elseif(auth()->user()->profession == "Solicitors")
                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                <source src="{{ asset('assets/knowledgebase/solicitor.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                        @elseif(auth()->user()->profession == "Will writers")
                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                <source src="{{ asset('assets/knowledgebase/willwriters.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                        @elseif(auth()->user()->profession == "Estate planners")
                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                <source src="{{ asset('assets/knowledgebase/estate_planners.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                        @elseif(auth()->user()->profession == "Financial advisers")
                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                <source src="{{ asset('assets/knowledgebase/financial_advisers.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                        @elseif(auth()->user()->profession == "Ifas")
                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                <source src="{{ asset('assets/knowledgebase/ifas.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                        @elseif(auth()->user()->profession == "Life insurance specialists")
                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                <source src="{{ asset('assets/knowledgebase/life_insurance_specialists.mp4') }}"
                                    type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                        @elseif(auth()->user()->profession == "Accountants")
                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                <source src="{{ asset('assets/knowledgebase/accountants.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                        @elseif(auth()->user()->profession == "Networks")
                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                <source src="{{ asset('assets/knowledgebase/networks.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                        @elseif(auth()->user()->profession == "Societies")
                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                <source src="{{ asset('assets/knowledgebase/socities.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                        @elseif(auth()->user()->profession == "Regulatory bodies")
                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                <source src="{{ asset('assets/knowledgebase/regulators.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @elseif(auth()->user()->profession == "Institutes")
                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                <source src="{{ asset('assets/knowledgebase/institues.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                <source src="{{ asset('assets/knowledgebase/video2.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h2 class="p-2">Video Title: Client Explainer</h2>
                        <video id="earningVideo" style="width:100%;height:390px;" controls>
                            <source src="{{ asset('assets/knowledgebase/video3.mp4') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h2 class="p-2">Video Title: Partner Success & Commission</h2>
                        <video id="earningVideo" style="width:100%;height:390px;" controls>
                            <source src="{{ asset('assets/knowledgebase/video4.mp4') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
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