<?php

namespace App\Http\Livewire;

use App\Models\Entidad;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\Traits\CrudTrait;
use App\Models\Municipio;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Municipios extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use CrudTrait;

    protected $listeners = ['destroy'];
    protected $rules = [
        'main_record.entidad_id'        => 'required|exists:entidades,id',
        'main_record.nombre'            => 'required|min:3|max:50|unique:municipios,nombre',
        'main_record.predeterminado'    => 'nullable'
    ];


    public function mount(){
        $this->manage_title = 'Gestionar Municipios';
        $this->search_label = 'Municipio';
        $this->view_form    = 'livewire.municipios.form';
        $this->view_table   = 'livewire.municipios.table';
        $this->view_list    = 'livewire.municipios.list';
        $this->main_record  = new Municipio();
        $this->entidades    = Entidad::orderby('nombre')->get();
        $this->sort         = 'entidad_id';
        $this->allow_create = false;
    }

    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */

    public function render(){
        $this->create_button_label = $this->main_record->id ?  'Actualizar Municipio' :  ' Crear Municipio';

        return view('livewire.index', [
            'records' => Municipio::General($this->search)->orderby('predeterminado','DESC')->orderby($this->sort,$this->direction)->paginate($this->pagination),
        ]);
    }

    public function resetInputFields()
    {
        $this->main_record = new Municipio();
        $this->resetErrorBag();
    }

    /*+---------------+
    | Guarda Registro |
    +-----------------+
    */

    public function store(){
        $this->rules['main_record.nombre'] = $this->main_record->id ? "required|min:3|max:50|unique:municipios,nombre,{$this->main_record->id}"
                                                                     : 'required|min:3|max:50|unique:municipios,nombre';

        $this->validate();
        if($this->predeterminado){
            $sql = "UPDATE municipios SET predeterminado=0";
            DB::update($sql);
        }

        $this->main_record->predeterminado = $this->predeterminado ? 1 : 0;

        $this->close_store('Municipio');
    }

    /*+------------------------------+
    | Lee Registro Editar o Borar  |
    +------------------------------+
    */

    public function edit(Municipio $record){
        $this->main_record      = $record;
        $this->record_id        = $record->id;
        $this->predeterminado   =  $this->main_record->predeterminado;
        $this->openModal();
    }

    /*+------------------------------+
      | Elimina Registro             |
      +------------------------------+
    */
    public function destroy(Municipio $record)
    {
        $this->delete_record($record, __('Municipio Eliminado Satisfactoriamente!!'));
    }
}
