
@foreach ($remainingTrays as $key => $item)
    <option value="{{ $key }}" {{ (old('tray_id') == $key  ) ? 'selected' : '' }}>{{ $item }}</option>
@endforeach
