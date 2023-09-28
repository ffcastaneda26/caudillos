<?php

namespace App\Http\Livewire;

use App\Models\Round;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;
use App\Http\Livewire\Traits\CrudTrait;
use App\Http\Livewire\Traits\FuncionesGenerales;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Rounds extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use CrudTrait;
    use FuncionesGenerales;

    protected $listeners = ['destroy'];

    protected $rules = [
        'main_record.start_date'=> 'required|date|before:main_record.end_date',
        'main_record.end_date'  => 'required|date|after:main_record.start_date',
        'main_record.active'    => 'nullable',
        'main_record.type'      => 'required|in:Regular,Divisional,Conferencia',
    ];


    public function mount(){
        $this->manage_title = 'Gestionar Jornadas';
        $this->search_label =  null;
        $this->view_search  =  null;
        $this->view_form    = 'livewire.rounds.form';
        $this->view_table   = 'livewire.rounds.table';
        $this->view_list    = 'livewire.rounds.list';
        $this->main_record  = new Round();
        $this->sort         = 'start_date';
    }

    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */

    public function render(){
        $this->create_button_label = $this->main_record->id ?  'Actualizar Jornada' :  ' Crear Jornada';

        return view('livewire.index', [
            'records' => Round::orderby($this->sort,$this->direction)->paginate(5),
        ]);

    }

    /*+------------------------------+
      | Lee Registro Editar o Borar  |
      +------------------------------+
    */

    public function edit(Round $record){
        $this->main_record  = $record;
        $this->record_id    = $record->id;
        $this->openModal();
    }

    /*+---------------+
    | Guarda Registro |
    +-----------------+
    */

    public function store(){
         $this->validate();

        if($this->main_record->active){
            DB::update("UPDATE rounds SET active=0");
        }
        $this->main_record->active = $this->main_record->active? 1 : 0;
        $this->close_store('Jornada');
    }


    // Restaura campos
    public function resetInputFields(){
        $this->main_record = new Round();
        $this->resetErrorBag();
    }

    /*+------------------------------+
      | Elimina Registro             |
      +------------------------------+
    */
    public function destroy(Round $record)
    {
        $this->delete_record($record, __('Jornada Eliminado Satisfactoriamente!!'));
    }


}
