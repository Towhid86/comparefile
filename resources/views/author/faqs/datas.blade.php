@foreach($faqs as $faq)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $faq->id }}" data-url="{{ route('author.faqs.delete-all') }}">
            <i class="{{ request('id') == $faq->id ? 'fas fa-bell text-red' : '' }}"></i>
        </td>
        <td>{{ $loop->index+1 }} <i class="{{ request('id') == $faq->id ? 'fas fa-bell text-red' : '' }}"></i></td>
        <td>{{ $faq->question }}</td>
        <td>{{ Str::limit($faq->answer, 80, '...') }}</td>
        <td class="text-center">
            @can('faqs-update')
                <label class="switch">
                    <input type="checkbox" {{ $faq->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('author.faqs.status', $faq->id) }}">
                    <span class="slider round"></span>
                </label>
            @else
                <div class="badge bg-{{ $faq->status == 1 ? 'success' : 'danger' }}">
                    {{ $faq->status == 1 ? 'Active' : 'Deactive' }}
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
                        <a href="#faqs-view-modal" class="view-btn" data-bs-toggle="modal"
                           id="faqs_view_{{ $faq->id }}"
                           data-id = "{{ $faq->id }}"
                           data-question = "{{ $faq->question }}"
                           data-answer = "{{ $faq->answer }}"
                           data-status = "{{ $faq->status }}">
                            <i class="fal fa-eye"></i>
                            {{ __('View') }}
                        </a>

                    </li>
                    @can('faqs-update')
                        <li><a  href="{{ route('author.faqs.edit', $faq->id) }}"><i class="fal fa-pencil-alt"></i>{{('Edit')}}</a></li>
                    @endcan
                    @can('faqs-delete')
                        <li>
                            <a href="{{ route('author.faqs.destroy', $faq->id) }}" class="confirm-action" data-method="DELETE">
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
