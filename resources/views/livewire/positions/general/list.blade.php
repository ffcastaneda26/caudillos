<tr>
    <td>{{ $loop->index + 1}}</td>
    <td>{{ $position->first_name }} {{ $position->last_name }}</td>
    <td align="center">{{ $position->hits ?  $position->hits : '-'}}</td>
    <td align="center">
        <img src="{{ $position->hit_last_games  ? asset('images/afirmativo.png') : asset('images/negativo.png') }}"
        width="17" height="17">
    </td>
    <td align="center">{{ $position->dif_total_points ? $position->dif_total_points : '-'}}</td>
</tr>

