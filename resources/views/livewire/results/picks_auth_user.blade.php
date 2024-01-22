                                        {{-- Datos del usuario conectado --}}
                                        <tr>
                                            <td class="bg-success text-white  text-xs">
                                                {{ Auth::user()->name }}
                                            </td>
                                            @foreach ($picks_auth_user_round as $pick_auth_user)
                                                @livewire('user-pick-game', ['user' => $pick_auth_user->user_id, 'game' => $pick_auth_user->game_id], key($pick_auth_user->user_id))
                                                @php
                                                    $visit_points = $pick_auth_user->visit_points;
                                                    $local_points = $pick_auth_user->local_points;
                                                    $hit_last_game = $pick_auth_user->winner == $pick_auth_user->game->winner;
                                                    $allow_pick = $pick_auth_user->game->allow_pick($configuration->minuts_before_picks);
                                                @endphp
                                            @endforeach
                                            <td
                                                class="text-base text-center {{ $hit_last_game ? 'text-success' : 'text-danger' }}">
                                                @if ($allow_pick)
                                                    <img src="{{ asset('images/reloj.png') }}" alt=""
                                                        width="32px" height="32px">
                                                @else
                                                    {{ $visit_points . '-' . $local_points }}
                                                @endif
                                            </td>
                                        </tr>
