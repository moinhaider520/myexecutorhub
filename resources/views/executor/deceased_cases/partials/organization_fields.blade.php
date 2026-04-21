<div class="row">
  <div class="col-md-6 mb-3">
    <label>Organisation Name</label>
    <input class="form-control" name="organisation_name" value="{{ $organization->organisation_name ?? '' }}" required>
  </div>
  <div class="col-md-6 mb-3">
    <label>Type</label>
    <select class="form-control" name="organisation_type" required>
      @foreach($organisationTypes as $key => $label)
        <option value="{{ $key }}" @selected(($organization->organisation_type ?? '') === $key)>{{ $label }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-6 mb-3">
    <label>Contact Name</label>
    <input class="form-control" name="organisation_contact_name" value="{{ $organization->organisation_contact_name ?? '' }}">
  </div>
  <div class="col-md-6 mb-3">
    <label>Email</label>
    <input class="form-control" type="email" name="organisation_email" value="{{ $organization->organisation_email ?? '' }}">
  </div>
  <div class="col-md-6 mb-3">
    <label>Reference</label>
    <input class="form-control" name="organisation_reference" value="{{ $organization->organisation_reference ?? '' }}">
  </div>
  <div class="col-md-6 mb-3">
    <label>Account Number</label>
    <input class="form-control" name="account_number" value="{{ $organization->account_number ?? '' }}">
  </div>
  <div class="col-md-6 mb-3">
    <label>Policy Number</label>
    <input class="form-control" name="policy_number" value="{{ $organization->policy_number ?? '' }}">
  </div>
  <div class="col-md-6 mb-3">
    <label>Customer Number</label>
    <input class="form-control" name="customer_number" value="{{ $organization->customer_number ?? '' }}">
  </div>
  <div class="col-md-6 mb-3">
    <label>Organisation Address</label>
    <textarea class="form-control" name="organisation_address" rows="3">{{ $organization->organisation_address ?? '' }}</textarea>
  </div>
  <div class="col-md-6 mb-3">
    <label>Service Address</label>
    <textarea class="form-control" name="service_address" rows="3">{{ $organization->service_address ?? '' }}</textarea>
  </div>
</div>
