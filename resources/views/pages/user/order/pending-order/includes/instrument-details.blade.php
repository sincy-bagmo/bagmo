<tr id="remove-instrument-{{ $categories->id }}">
    <td>
        <div class="d-flex align-items-center">
            <div class="fw-bolder">{{  Str::limit($categories->category_name, 20) }}</div>
        </div>
    </td>
    <td>
        <div class="d-flex align-items-center">
            <div class="d-flex flex-column">{{ $categories->code }}</div>
        </div>
    </td>
    <td><div class="input-group"><input class="touchspin-cart" type="number" name="category_id_{{ $categories->id }}" value="1"></div></td>
</tr>
