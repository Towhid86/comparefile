@foreach($businesses  as $business)
    <tr>
        <td class="w-60 checkbox">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $business->id }}" data-url="{{ route('author.business.delete-all') }}">
            <i class="{{ request('id') == $business->id ? 'fas fa-bell text-red' : '' }}"></i>
        </td>
        <td>{{ $loop->index+1 }} <i class="{{ request('id') == $business->id ? 'fas fa-bell text-red' : '' }}"></i></td>
        <td>{{ formatted_date($business->created_at) }}</td>
        <td>{{ $business->name }}</td>
        <td>{{ $business->businessCategory->name ?? '' }}</td>
        <td>{{ $business->plan->name ?? '' }}</td>
        <td>{{ $business->plan->type ?? '' }}</td>
        <td>N/A</td>
        @php
            $remainingDays = null;
            if ($business->plan) {
                $startDate = $business->created_at; // current date
                //$endDate = $startDate->copy()->add($business->plan->duration, $business->plan->duration_type);
                //$remainingDays = $endDate->diffInDays(now());
            }
        @endphp
        <td>{{ $business->plan->duration ?? '' }} {{ $business->plan->duration_type ?? '' }} ({{ $remainingDays > 0 ? $remainingDays : 0 }} Days Left) </td>
        <td class="{{ $remainingDays > 0 ? 'text-success' : 'text-danger' }}">{{ $remainingDays > 0 ? 'Active' : 'Expired' }}</td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
{{--                    <li>--}}
{{--                        <a href="#user-view-modal" class="view-btn" data-bs-toggle="modal"--}}
{{--                           id="user_view_{{ $business->id }}"--}}
{{--                           data-id = "{{ $business->id }}"--}}
{{--                           data-business_category = "{{ $business->businessCategory->name ?? ''  }}"--}}
{{--                           data-business_name = "{{ $business->business_name }}"--}}
{{--                           data-image="{{ asset($business->image) }}"--}}
{{--                           data-name = "{{ $business->name }}"--}}
{{--                           data-role = "{{ $business->role }}"--}}
{{--                           data-email = "{{ $business->email }}"--}}
{{--                           data-phone = "{{ $business->phone }}"--}}
{{--                           data-address = "{{ $business->address }}"--}}
{{--                           data-country_id = "{{ $business->country->nick_name ?? '' }}"--}}
{{--                           data-status = "{{ $business->status }}">--}}
{{--                            <i class="fal fa-eye"></i>--}}
{{--                            {{ __('View Features') }}--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    @can('business-update')
                        <li><a href="{{ route('author.business.edit', $business->id) }}"><i class="fal fa-pencil-alt"></i>{{('Edit')}}</a></li>
                    @endcan
                    @can('business-delete')
                        <li>
                            <a href="{{ route('author.business.destroy', $business->id) }}" class="confirm-action"
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
