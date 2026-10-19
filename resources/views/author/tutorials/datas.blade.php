@foreach($tutorials  as $tutorial)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $tutorial->id }}" data-url="{{ route('author.tutorials.delete-all') }}">
            <i class="{{ request('id') == $tutorial->id ? 'fas fa-bell text-red' : '' }}"></i>
        </td>
        <td>{{ $loop->index+1 }} <i class="{{ request('id') == $tutorial->id ? 'fas fa-bell text-red' : '' }}"></i></td>
        <td>
            <img class="table-img rounded-circle" src="{{ Storage::url($tutorial->thumbnail) }}" alt="img">
        </td>
        <td>{{ $tutorial->title }}</td>
        <td>{{ $tutorial->description }}</td>
        <td class="text-center">
            @can('tutorials-update')
                <label class="switch">
                    <input type="checkbox" {{ $tutorial->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('author.tutorials.status', $tutorial->id) }}">
                    <span class="slider round"></span>
                </label>
            @else
                <div class="badge bg-{{ $tutorial->status == 1 ? 'success' : 'danger' }}">
                    {{ $tutorial->status == 1 ? 'Active' : 'Deactive' }}
                </div>
            @endcan
        </td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('tutorials-update')
                        <li><a href="{{ route('author.tutorials.edit', $tutorial->id) }}"><i class="fal fa-pencil-alt"></i>{{('Edit')}}</a></li>
                    @endcan
                    @can('tutorials-delete')
                        <li>
                            <a href="{{ route('author.tutorials.destroy', $tutorial->id) }}" class="confirm-action"
                               data-method="DELETE">
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
