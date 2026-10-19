@foreach($plans as $plan)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $plan->id }}" data-url="{{ route('author.plans.delete-all') }}">
            <i class="{{ request('id') == $plan->id ? 'fas fa-bell text-red' : '' }}"></i>
        </td>
        <td>{{ $loop->index+1 }} <i class="{{ request('id') == $plan->id ? 'fas fa-bell text-red' : '' }}"></i></td>
        <td>{{ $plan->name }}</td>
        <td>{{ $plan->type == 'mobile_desktop' ? 'mobile+desktop' : $plan->type }}</td>
        <td>{{ ucfirst($plan->role) }}</td>
        <td>{{ $plan->price }}$</td>
        <td>{{ $plan->discount_type == 'fixed' ? $plan->discount . '$' : $plan->discount . '%' }}</td>
        <td>{{ $plan->sales_price  }}$</td>
        <td>{{ $plan->duration }} {{ $plan->duration > 1 ? ucfirst($plan->duration_type) . 's' : ucfirst($plan->duration_type) }}</td>

        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#plan-view-modal" class="view-btn" data-bs-toggle="modal"
                           id="plan_view_{{ $plan->id }}"
                           data-id = "{{ $plan->id }}"
                           data-features = "{{ json_encode($plan->features) }}">
                            <i class="fal fa-eye"></i>
                            {{ __('View Features') }}
                        </a>

                    </li>
                    @can('plans-update')
                        <li><a  href="{{ route('author.plans.edit', $plan->id) }}"><i class="fal fa-pencil-alt"></i>{{('Edit')}}</a></li>
                        @endcan
                        @can('plans-delete')
                        <li>
                            <a href="{{ route('author.plans.destroy', $plan->id) }}" class="confirm-action" data-method="DELETE">
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
