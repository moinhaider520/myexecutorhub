@isset($charities)
    @foreach ($charities as $charity)
        <label for="{{ $charity->name }}" class="charity-text-item">
            <input type="checkbox" id="{{ $charity->name }}" name="charities[]" value="{{ $charity->name }}" checked>
            <div class="charity-text-details">
                <span class="charity-text-name">{{ $charity->name }}</span>
            </div>
        </label>
    @endforeach
@endisset
