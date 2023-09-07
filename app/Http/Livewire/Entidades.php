<?php

namespace App\Http\Livewire;

use App\Models\Entidad;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\Traits\CrudTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Entidades extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use CrudTrait;

    protected $listeners = ['destroy'];
    protected $rules = [
        'main_record.nombre'           => 'required|min:3|max:50|unique:entidades,nombre',
        'main_record.abreviado'         => 'required|min:3|max:10|unique:entidades,abreviado',
        'main_record.predeterminado'    => 'nullable'
    ];



    public function mount(){
        $this->manage_title = 'Entidades Federativas';
        $this->search_label = 'Entidad';
        $this->view_form    = 'livewire.entidades.form';
        $this->view_table   = 'livewire.entidades.table';
        $this->view_list    = 'livewire.entidades.list';
        $this->main_record  = new Entidad();
        $this->sort         = 'nombre';
        $this->allow_create = false;
    }

    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */

    public function render(){
        $this->create_button_label = $this->main_record->id ?  'Actualizar Entidad' :  ' Crear Entidad';

        return view('livewire.index', [
            'records' => Entidad::General($this->search)->orderby('predeterminado','DESC')->orderby($this->sort,$this->direction)->paginate($this->pagination),
        ]);
    }

    public function resetInputFields()
    {
        $this->main_record = new Entidad();
        $this->resetErrorBag();
    }

    /*+---------------+
    | Guarda Registro |
    +-----------------+
    */

    public function store(){
        $this->rules['main_record.nombre'] = $this->main_record->id ? "required|min:3|max:50|unique:entidades,nombre,{$this->main_record->id}"
                                                                     : 'required|min:3|max:50|unique:entidades,nombre';
        $this->rules['main_record.abreviado'] = $this->main_record->id ? "required|min:3|max:10|unique:entidades,abreviado,{$this->main_record->id}"
                                                                     : 'required|min:3|max:10|unique:entidades,abreviado';

        $this->validate();
        if($this->predeterminado){
            $sql = "UPDATE entidades SET predeterminado=0";
            DB::update($sql);
        }

        $this->main_record->predeterminado = $this->predeterminado ? 1 : 0;

        $this->close_store('Entidad');
    }

    /*+------------------------------+
    | Lee Registro Editar o Borar  |
    +------------------------------+
    */

    public function edit(Entidad $record){
        $this->main_record      = $record;
        $this->record_id        = $record->id;
        $this->predeterminado   =  $this->main_record->predeterminado;
        $this->openModal();
    }

    /*+------------------------------+
      | Elimina Registro             |
      +------------------------------+
    */
    public function destroy(Entidad $record)
    {
        $this->delete_record($record, __('Entidad Federativa Eliminada Satisfactoriamente!!'));
    }
}
