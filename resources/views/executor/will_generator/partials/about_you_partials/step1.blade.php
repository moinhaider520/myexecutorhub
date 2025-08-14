<div class="stepper-one row g-3 needs-validation custom-input" novalidate="" style="display: flex;">
    <input type="hidden" name="will_user_id" value="{{@$user_info->id}}">
    <div class="col-sm-12">
        <label class="form-label">What’s your full legal name?</label>
        <p>This is the name on your passport or driving licence. For example, Elizabeth Joy Smith.</p>
        <input class="form-control" name="legal_name" type="text" value="{{@$user_info->legal_name}}" required>
    </div>

    <div class="col-sm-12">
        <label class="form-label">What would you like us to call you?</label>
        <p>The name you’d like us to use when we send you a message or talk to you on the phone. For example, Lizzie. (optional)</p>
        <input class="form-control" name="user_name" type="text" value="{{@$user_info->user_name}}" required>
    </div>

    <div class="col-sm-12">
        <label class="form-label">Your date of birth</label>
        <p>For example, 19/12/1951</p>
        <input class="form-control" name="date_of_birth" type="date" value="{{@$user_info->date_of_birth}}" required>
    </div>
</div>
