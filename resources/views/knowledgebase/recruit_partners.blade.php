@extends('layouts.master')

@section('content')

    <div class="page-body knowledgebase-shell">
        @include('knowledgebase.partials.styles')
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card knowledgebase-card">
                        <h2 class="mb-4">Multiply Your Income</h2>
                        <p>Many partners introduce Executor Hub to other advisers they already know. When those advisers join, start referring clients, and build activity, your network effect becomes much stronger.</p>

                        <h2 class="mb-4">Why This Matters</h2>
                        <p>If you introduce 5 advisers and each adviser introduces 50 clients, that creates 250 Executor Hub customers connected to your network. That is why partner recruitment can become such a powerful income multiplier.</p>

                        <h2 class="mb-4">Simple Way To Explain It</h2>
                        <p>Tell other advisers that Executor Hub helps families organise affairs while also creating a recurring income opportunity for professionals who recommend it responsibly.</p>

                        <h2 class="mb-4">Starter Email</h2>
                        <div class="border rounded-4 p-4">
                            <p class="mb-2">Hi [Name]</p>
                            <p class="mb-2">I&apos;ve partnered with a platform called Executor Hub that helps executors manage estates and also creates recurring income for advisers.</p>
                            <p class="mb-2">Many of my clients are finding it really useful.</p>
                            <p class="mb-2">If you're interested I'm happy to show you how the partner programme works.</p>
                            <p class="mb-0">Best<br>[Name]</p>
                        </div>

                        <h2 class="mb-4">Quick Actions</h2>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('partner.partners.create') }}" class="btn btn-primary">Create Partner</a>
                            <a href="{{ route('partner.partners.index') }}" class="btn btn-outline-primary">View Partners</a>
                            <a href="{{ route('partner.commission_calculator.index') }}" class="btn btn-outline-primary">Open Calculator</a>
                        </div>

                        @include('knowledgebase.partials.next_step', [
                            'nextHeading' => 'Give partners a 90-day roadmap',
                            'nextUrl' => route('partner.knowledgebase.growth_plan'),
                            'nextLabel' => 'Partner Growth Plan',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
