    <div class="mb-1">
        <label  class="form-label">Rack Name<span class="text-danger">*</span></label>
        <select name="storage_rack_id" id="storage_rack_id" class="form-select">
            <option value="">Select Rack</option>
            @foreach ($rack as $key => $item)
                <option value="{{ $key }}" {{ (old('storage_rack_id') == $key  ) ? 'selected' : '' }}>{{ $item }}</option>
            @endforeach
        </select>
        @error('storage_rack_id')
        <span id="storage_rack_id-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
        @enderror
    </div>