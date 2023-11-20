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

    private $pagination = 15; //paginación de tabla

    public function render(){
        $positions = GeneralPosition::orderby('position','asc')->paginate($this->pagination);
        return view('livewire.positions.general.index', [
            'records' => $positions,
        ]);
    }


}


