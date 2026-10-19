@foreach($payment_types as $type)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $type->id }}" data-url="{{ route('author.payment-types.delete-all') }}">
            <i class="{{ request('id') == $type->id ? 'fas fa-bell text-red' : '' }}"></i>
        </td>
        <td>{{ $loop->index+1 }} <i class="{{ request('id') == $type->id ? 'fas fa-bell text-red' : '' }}"></i></td>
        <td>{{ $type->name }}</td>
        <td class="text-center">
            @can('payment-types-update')
                <label class="switch">
                    <input type="checkbox" {{ $type->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('author.payment-types.status', $type->id) }}">
                    <span class="slider round"></span>
                </label>
            @else
                <div class="badge bg-{{ $type->status == 1 ? 'success' : 'danger' }}">
                    {{ $type->status == 1 ? 'Active' : 'Deactive' }}
                </div>
            @endcan
        </td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('payment-types-update')
                        <li><a href="#payment-type-edit-modal" class="edit-btn" data-bs-toggle="modal"
                               id="payment_type_edit_{{ $type->id }}"
                               data-id = "{{ $type->id }}"
                               data-url="{{ url('/author/payment-types') }}"
                               data-name="{{ $type->name }}"
                               data-status="{{ $type->status }}">
                                <i class="fal fa-pencil-alt"></i>
                                {{__('Edit')}}
                            </a>

                    @endcan
                    @can('payment-types-delete')
                        <li>
                            <a href="{{ route('author.payment-types.destroy', $type->id) }}" class="confirm-action" data-method="DELETE">
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
