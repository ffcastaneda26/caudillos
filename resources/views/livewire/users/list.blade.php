<tr>
    <td>{{ $record->name }}</td>
    <td>{{ $record->email }}</td>
    <td>{{ $record->phone }}</td>
    <td>{{ $record->getRoleNames()->first() }}</td>
    <td class="border text-center">
        <img src="{{ $record->active ? asset('images/afirmativo.png') : asset('images/negativo.png')}}"
        alt="{{ $record->active ? __('Yes') : 'No' }}"
        height="24px"
        width="24px">
    </td>
    <td class="px-1 text-center">
        <button
                wire:click="edit({{ $record->id }})"
                class="btn btn-success waves-effect waves-light"
                title="{{__("Edit")}}">
                <i class="mdi mdi-eye-circle"></i>
            </button>
    </td>
</tr>
