<?php

namespace App\Http\Livewire\Positions;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\Traits\CrudTrait;
use App\Http\Livewire\Traits\FuncionesGenerales;
use App\Models\GeneralPosition;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class General extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use FuncionesGenerales;

    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */

    public function render(){
        $positions = $this->read_records_to_general_positions();
        $positions = GeneralPosition::orderby('position','desc')->paginate(5);
        return view('livewire.positions.general.index', [
            'records' => $positions,
        ]);
    }

}


