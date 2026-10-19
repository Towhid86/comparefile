@foreach($business_categories as $category)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $category->id }}" data-url="{{ route('author.business-categories.delete-all') }}">
            <i class="{{ request('id') == $category->id ? 'fas fa-bell text-red' : '' }}"></i>
        </td>
        <td>{{ $loop->index+1 }} <i class="{{ request('id') == $category->id ? 'fas fa-bell text-red' : '' }}"></i></td>
        <td>{{ $category->name }}</td>
        <td>{{ $category->description }}</td>
        <td class="text-center">
            @can('business-categories-update')
                <label class="switch">
                    <input type="checkbox" {{ $category->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('author.business-categories.status', $category->id) }}">
                    <span class="slider round"></span>
                </label>
            @else
                <div class="badge bg-{{ $category->status == 1 ? 'success' : 'danger' }}">
                    {{ $category->status == 1 ? 'Active' : 'Deactive' }}
                </div>
            @endcan
        </td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#category-view-modal" class="view-btn" data-bs-toggle="modal"
                           id="category_view_{{ $category->id }}"
                           data-id = "{{ $category->id }}"
                           data-name = "{{ $category->name }}"
                           data-description = "{{ $category->description }}"
                           data-status = "{{ $category->status }}">
                            <i class="fal fa-eye"></i>
                            {{ __('View') }}
                        </a>

                    </li>
                    @can('business-categories-update')
                        <li><a  href="{{ route('author.business-categories.edit', $category->id) }}"><i class="fal fa-pencil-alt"></i>{{('Edit')}}</a></li>
                    @endcan
                    @can('business-categories-delete')
                        <li>
                            <a href="{{ route('author.business-categories.destroy', $category->id) }}" class="confirm-action" data-method="DELETE">
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
