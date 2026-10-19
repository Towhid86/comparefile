@foreach ($testimonials as $testimonial )
<tr>
    @can('testimonials-delete')
        <td class="checkbox text-start">
            <input type="checkbox" name="ids[]" class="checkbox-item" value="{{ $testimonial->id }}" data-url="{{ route('author.testimonials.delete-all') }}">
        </td>
    @endcan
    <td>{{ $loop->index + 1 }}</td>
    <td>
        @for ($i = 0; $i < 5; $i++)
            <i @class(['fas fa-star ', 'text-warning' => $testimonial->star > $i])></i>
        @endfor
    </td>
    <td>{{ $testimonial->name }}</td>
    <td>{{ $testimonial->work_at }}</td>
    <td>
        <img class="table-img" src="{{ asset($testimonial->image) }}" alt="img">
    </td>
    <td class="text-center w-150">
        <label class="switch">
            <input type="checkbox" {{ $testimonial->status == 1 ? 'checked' : '' }} class="status"
                data-url="{{ route('author.testimonials.status', $testimonial->id) }}" data-model="Testimonial">
            <span class="slider round"></span>
        </label>
    </td>
    <td class="print-d-none">
        <div class="dropdown table-action">
            <button type="button" data-bs-toggle="dropdown">
                <i class="far fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('author.testimonials.edit',$testimonial->id) }}">
                        <i class="fal fa-pencil-alt"></i>
                        {{ __('Edit') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('author.testimonials.destroy', $testimonial->id) }}" class="confirm-action" data-method="DELETE">
                        <i class="fal fa-trash-alt"></i>
                        {{ __('Delete') }}
                    </a>
                </li>
            </ul>
        </div>
    </td>
</tr>
@endforeach
