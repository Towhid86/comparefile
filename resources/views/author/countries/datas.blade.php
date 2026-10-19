@foreach($countries as $country )
    <tr>
        <td>{{ $loop->iteration }} <i class="{{ request('id') == $country->id ? 'fas fa-bell text-red' : '' }}"></i></td>
        <td>{{ $country->name }}</td>
        <td>{{ $country->nick_name }}</td>
        <td>{{ $country->alpha2_code }}</td>
        <td>{{ $country->alpha3_code }}</td>
        <td>{{ $country->phone_code }}</td>

        {{-- <td>
            <div class="{{ $country->status == 1 ? 'badge bg-success' : 'badge bg-danger' }}">
                {{ $country->status == 1 ? 'Active' : 'Inactive' }}
            </div>
        </td> --}}

        <td class="text-center w-150">
            <label class="switch">
                <input type="checkbox" {{ $country->status == 1 ? 'checked' : '' }} class="status" data-id ="{{$country->id}}" data-status-text="Country">
                <span class="slider round"></span>
            </label>
        </td>
        <td>
            <div class="{{ $country->default == 1 ? 'badge bg-success' : 'badge bg-danger' }}">
                {{ $country->default == 1 ? 'Yes' : 'No' }}
            </div>
        </td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('countries-update')

                        <li>
                            <a href="{{-- {{ route('author.countries.default', ['id' => $country->id]) }} --}}">
                                <i class="fas fa-adjust"></i>
                                {{__('Make Default')}}
                            </a>
                        </li>

                        <li><a  href="" class="edit-btn" data-bs-toggle="modal" data-bs-target="#country-modal"
                            id="country_edit_{{ $country->id }}"
                           data-id = "{{ $country->id }}"
                           data-name = "{{  $country->name  }}"
                           data-nick_name = "{{  $country->nick_name  }}"
                           data-phone_code = "{{  $country->phone_code  }}"
                           data-alpha2_code = "{{  $country->alpha2_code  }}"
                           data-alpha3_code = "{{  $country->alpha3_code  }}"
                           data-url="{{ route('author.countries.update', $country->id) }}"
                            ><i class="fal fa-pencil-alt"></i>{{('Edit')}}</a></li>
                    @endcan

                    @can('countries-delete')
                        <li>
                            <a href="{{ route('author.countries.destroy', $country->id) }}" class="confirm-action" data-method="DELETE">
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
