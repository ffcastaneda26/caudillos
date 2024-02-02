<?php

namespace App\Http\Livewire\Positions;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GeneralPosition;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use App\Http\Livewire\Traits\CrudTrait;
use App\Http\Livewire\Traits\FuncionesGenerales;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class General extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use FuncionesGenerales;
    use CrudTrait;

    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */

    private $pagination = 15; //paginación de tabla
    public $order_by = 'position_asc';

    public function mount(){
        $this->read_configuration();
        $this->validate_require_payment_to_continue();
        $this->validate_has_sumplentary_data_to_continue();
    }
    public function render()
    {
        return view('livewire.positions.general.index', [
            'records' => $this->read_data()
        ]);
    }


    public function read_data()
    {
        $this->determinate_orderby_and_direction();

        $results = DB::table('general_positions as gp')
            ->join('users as us', 'us.id', '=', 'gp.user_id')
            ->where('us.active', '1')
            ->where('first_name', 'LIKE', "%$this->search%")
            ->orwhere('last_name', 'LIKE', "%$this->search%")
            ->orwhere('email', 'LIKE', "%$this->search%")
            ->select(DB::raw('CONCAT(us.first_name, " ", us.last_name) AS name'), 'gp.*');

        if ($this->sort === 'name') {
            $results->orderBy(DB::raw('CONCAT(us.first_name, " ", us.last_name)'), $this->direction);
        } else {
            $results->orderBy('position', $this->direction);
        }

        $results = $results->paginate($this->pagination);

        return $results;

    }

    private function determinate_orderby_and_direction()
    {
        switch ($this->order_by) {
            case 'name_asc':
                $this->sort = 'name';
                $this->direction = 'asc';
                break;
            case 'name_desc':
                $this->sort = 'name';
                $this->direction = 'desc';
                break;
            case 'position_asc':
                $this->sort = 'position';
                $this->direction = 'asc';
                break;
            case 'position_desc':
                $this->sort = 'position';
                $this->direction = 'desc';
                break;
            default:
                $this->sort = 'position';
                $this->direction = 'asc';
                break;
        }
    }
}
