@foreach ($designs as $design)
<tr>
    @can('designs-delete')
        <td class="checkbox text-start">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $design->id }}" data-url="{{ route('author.designs.deleteAll') }}">
        </td>
    @endcan
    <td>{{ $loop->index + 1 }}</td>
    <td>
        <img class="table-img" src="{{ asset($design->value['image']) }}" alt="img">
    </td>
    <td>
        <label class="switch">
            <input type="checkbox" class="status" {{ $design->status == 1 ? 'checked' : '' }} data-url="{{ route('author.designs.status', $design->id) }}">
            <span class="slider round"></span>
        </label>
    </td>
    <td class="print-d-none">
        <div class="dropdown table-action">
            <button type="button" data-bs-toggle="dropdown">
                <i class="far fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu">
                @can('designs-update')
                <li>
                    <a href="{{ route('author.designs.edit', $design->id) }}">
                        <i class="fal fa-pencil-alt"></i>
                        {{ __('Edit') }}
                    </a>
                </li>
                @endcan
                @can('designs-delete')
                <li>
                    <a href="{{ route('author.designs.destroy', $design->id) }}" class="confirm-action" data-method="DELETE">
                        <i class="fal fa-trash-alt"></i>
                        {{ __('Delete') }}
                    </a>
                </li>
                @endcan
            </ul>
        </div>
    </td>
</tr>
@endforeach
