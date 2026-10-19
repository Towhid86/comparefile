@foreach($languages  as $language)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $language->id }}" data-url="{{ route('author.languages.delete-all') }}">
            <i class="{{ request('id') == $language->id ? 'fas fa-bell text-red' : '' }}"></i>
        </td>
        <td>{{ $loop->index+1 }} <i class="{{ request('id') == $language->id ? 'fas fa-bell text-red' : '' }}"></i></td>
        <td>
            @if($language->flag)
                <img class="table-img rounded-circle" src="{{ asset('/flags/'.$language->flag) }}" alt="img">
            @endif

        </td>
        <td>{{ $language->name }}</td>
        <td>{{ $language->alias }}</td>
        <td>{{ $language->direction }}</td>
        <td>
            <div class="badge bg-{{ $language->default == 1 ? 'success' : 'danger' }}">
                {{ $language->default == 1 ? 'Yes' : 'No' }}
            </div>
        </td>
        <td class="text-center">
            @can('languages-update')
                <label class="switch">
                    <input type="checkbox" {{ $language->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('author.languages.status', $language->id) }}"data-status-model="Language">
                    <span class="slider round"></span>
                </label>
            @else
                <div class="badge bg-{{ $language->status == 1 ? 'success' : 'danger' }}">
                    {{ $language->status == 1 ? 'Active' : 'Deactive' }}
                </div>
            @endcan
        </td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('languages-update')
                        <li><a href="{{ route('author.languages.edit', $language->id) }}" class="edit-btn" data-bs-toggle="modal" data-bs-target="#language-modal"
                            id="language_edit_{{ $language->id }}"
                            data-id = "{{ $language->id }}"
                           data-name = "{{  $language->name  }}"
                           data-alias = "{{  $language->alias  }}"
                           data-direction = "{{  $language->direction  }}"
                           data-flag = "{{  $language->flag  }}"
                           data-url="{{ route('author.languages.update', $language->id) }}"><i class="fal fa-pencil-alt"></i>{{('Edit')}}</a></li>
                    @endcan
                    @can('languages-delete')
                        <li>
                            <a href="{{ route('author.languages.destroy', $language->id) }}" class="confirm-action"
                               data-method="DELETE">
                                <i class="fal fa-trash-alt"></i>
                                {{ __('Delete') }}
                            </a>
                        </li>
                    @endcan
                    @if($language->default != 1)
                        @can('languages-default')
                            <li>
                                <a href="{{ route('author.languages.default', $language->id) }}" class="confirm-action">
                                  {{ __('Make Default') }}
                                </a>
                            </li>
                        @endcan
                    @endif
                </ul>
            </div>
        </td>
    </tr>
@endforeach
