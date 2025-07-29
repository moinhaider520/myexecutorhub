@isset($partners)
@forelse ($partners as $executor)
<div class="executor-card">
    <label>
        <input type="checkbox" name="executors[]" value="{{$executor->id}}">
        <div class="executor-details">
            <span class="executor-name">{{ @$executor->first_name }}
                {{ @$executor->lastname }}</span>
            <span class="executor-contact">{{@$executor->email}}</span>
        </div>
    </label>
    <a data-toggle="modal" data-target="#editExecutorModal"
        data-id="{{ $executor->id }}" data-name="{{ $executor->first_name }}"
        data-last_name="{{ $executor->last_name }}"
        data-email="{{ $executor->email }}"
        data-relationship="{{ $executor->type }}"
        data-phone_number="{{ $executor->phone_number }}" class="edit-button">Edit</a>
</div>
@empty
<p class="text-gray-600 italic">No friends or family executors added yet. Click "Add
    someone new" to get started.</p>
@endforelse
@endisset