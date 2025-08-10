<div class="stepper-two row g-3 needs-validation custom-input" novalidate="" style="display: none;">
    <div class="col-md-12">
        <h3>Your Address</h3>
    </div>
    <div class="col-md-12">
        <label class="form-label">Address line 1</label>
        <input class="form-control" name="address_line_1" type="text" value="{{@$user_info->address_line_1}}" required>
    </div>
    <div class="col-md-12">
        <label class="form-label">Address line 2 (optional)</label>
        <input class="form-control" name="address_line_2" type="text" value="{{@$user_info->address_line_2}}">
    </div>
    <div class="col-md-6">
        <label class="form-label">City</label>
        <input class="form-control" name="city" type="text" value="{{@$user_info->city}}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Postcode</label>
        <input class="form-control" name="post_code" type="text" value="{{@$user_info->post_code}}" required>
    </div>
    <div class="col-md-12">
        <h3>Your Phone Number</h3>
    </div>
    <div class="col-md-12">
        <label class="form-label">We’ll only call you to help you with your will.</label>
        <input class="form-control" name="phone_number" type="text" value="{{@$user_info->phone_number}}" required>
    </div>
</div>
