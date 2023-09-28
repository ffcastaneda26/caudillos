<tr class="text-base">
    <td>{{$record->start_date->format('j-M-y')}}</td>
    <td>{{$record->end_date->format('j-M-y')}}</td>
    <td class="text-center">
        <img src="{{ $record->active ? asset('images/afirmativo.png') : asset('images/negativo.png')}}"
            alt="{{ $record->active ? __('Yes') : 'No' }}"
            height="24px"
            width="24px">
    </td>
    <td>{{ $record->type }}</td>
    @include('common.crud_actions')
</tr>
