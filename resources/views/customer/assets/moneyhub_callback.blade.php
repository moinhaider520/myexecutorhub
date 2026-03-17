@extends('layouts.master')

@section('content')
  <div class="page-body">
    <div class="container-fluid default-dashboard">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="card">
            <div class="card-body text-center py-5">
              <h4>Finalising your bank connection</h4>
              <p class="text-muted mb-0">Please wait while we securely import your Moneyhub account data.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form id="moneyhub-callback-form" method="POST" action="{{ route('customer.bank_accounts.moneyhub.handle-callback') }}" style="display:none;">
    @csrf
    <input type="hidden" name="code" id="moneyhub-code">
    <input type="hidden" name="state" id="moneyhub-state">
    <input type="hidden" name="id_token" id="moneyhub-id-token">
    <input type="hidden" name="error" id="moneyhub-error">
    <input type="hidden" name="error_description" id="moneyhub-error-description">
  </form>

  <script>
    (function () {
      const form = document.getElementById('moneyhub-callback-form');
      const searchParams = new URLSearchParams(window.location.search);
      const hashParams = new URLSearchParams(window.location.hash.replace(/^#/, ''));
      const pick = (key) => hashParams.get(key) || searchParams.get(key) || '';

      document.getElementById('moneyhub-code').value = pick('code');
      document.getElementById('moneyhub-state').value = pick('state');
      document.getElementById('moneyhub-id-token').value = pick('id_token');
      document.getElementById('moneyhub-error').value = pick('error');
      document.getElementById('moneyhub-error-description').value = pick('error_description');

      if (window.history.replaceState) {
        window.history.replaceState({}, document.title, window.location.pathname);
      }

      form.submit();
    })();
  </script>
@endsection
