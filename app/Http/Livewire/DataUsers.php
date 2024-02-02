<?php

namespace App\Http\Livewire;

use session;
use App\Models\Entidad;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Traits\CrudTrait;
use Illuminate\Support\Facades\Storage;
use App\Http\Livewire\Traits\Validaciones;
use App\Http\Livewire\Traits\FuncionesGenerales;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DataUsers extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use WithFileUploads;
    use CrudTrait;
    use FuncionesGenerales;
    use Validaciones;

    protected $listeners = ['store_data'];


    protected $rules = [
        'main_record.gender'        => 'required|:in:Hombre,Mujer',
        'main_record.birthday'      => 'required|date',
        'main_record.curp'          => 'required|unique:profiles,curp',
        'main_record.entidad_id'    => 'required|exists:entidades,id',
        'main_record.municipio_id'  => 'required|exists:municipios,id',
        'main_record.codpos'        => 'required|numeric',
        'ine_anverso'   => 'required|image|max:5120|mimes:jpg,jpeg,png',
        'ine_reverso'   => 'required|image|max:5120|mimes:jpg,jpeg,png',
        'confirmar'     => 'accepted',
    ];


    public $error_message = null;
    public $entidades   = null;
    public $entidad     = null;
    public $municipios  = null;
    public $municipio   = null;


    public $ine_anverso     = null;
    public $ine_reverso     = null;
    public $extensions_file = ['jpg', 'jpeg', 'png'];
    public $confirmar       = null;
    public $profile         = null;

    public $ine_anverso_anterior = null;
    public $ine_reverso_anterior = null;


    public function mount()
    {
        $this->manage_title = 'Datos Complementarios';
        $this->search_label = null;
        $this->view_search  = null;
        $this->view_form    = 'livewire.datausers.form';
        $this->view_table   = 'livewire.datausers.table';
        $this->view_list    = 'livewire.datausers.list';
        $this->main_record  =  new Profile();
        $this->read_profile();
        $this->read_configuration();
        $this->lee_entidades();
        $this->modal_size   = 'modal-lg';
        $this->lee_entidad();
        $this->openModal();
    }

    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */

    public function render()
    {
        $this->read_profile();
        return view('livewire.datausers.index');
    }


    public function store_data()
    {
        $this->reset('error_message');
        if ($this->main_record->curp) {
            $this->main_record->curp = strtoupper($this->main_record->curp);
        }

        $this->validate();

        if (!$this->validaCURP($this->main_record->curp)) {
            $this->error_message = 'Revise la CURP, al parecer está mal integrada';
            return false;
        }

        if (!$this->profile) {
            $this->main_record->user_id = Auth::user()->id;
        }

        $this->main_record->save();

        if ($this->ine_anverso) {
            if ($this->ine_anverso_anterior) {
                Storage::delete($this->ine_anverso_anterior);
            }

            $nombre_archivo = 'ine_' . str_pad($this->main_record->user->id, 3, '0', STR_PAD_LEFT) . '_' . $this->ine_anverso->getClientOriginalName();
            $Image = $this->ine_anverso->storeAs('public/ines', $nombre_archivo);
            $this->main_record->ine_anverso = $Image;
        }

        if ($this->ine_reverso) {
            if ($this->ine_reverso_anterior) {
                Storage::delete($this->ine_reverso_anterior);
            }
            $nombre_archivo = 'ine_' . str_pad($this->main_record->user->id, 3, '0', STR_PAD_LEFT) . '_' . $this->ine_reverso->getClientOriginalName();
            $Image = $this->ine_reverso->storeAs('public/ines', $nombre_archivo);
            $this->main_record->ine_reverso = $Image;
        }
        $this->main_record->save();
        $message = 'Datos Complementarios Actualizados';
        $this->show_alert('success', $message);
        $this->closeModal();
        $this->resetInputFields();
        return redirect()->route('dashboard');
    }

    /** Lee los datos complemenatrios del perfil */

    public function read_profile()
    {
        $this->profile      = Auth::user()->profile;
        if ($this->profile) {
            $this->allow_create         = false;
            $this->main_record          = $this->profile;
            $this->ine_anverso_anterior = $this->main_record->ine_anverso;
            $this->ine_reverso_anterior = $this->main_record->ine_reverso;
            $this->allow_edit           = false;
        }
    }
    /** Lee entidades */

    public function lee_entidades()
    {
        $this->entidades = Entidad::orderby('predeterminado', 'Desc')
            ->orderby('nombre')
            ->get();
        $this->lee_entidad();
    }


    /** Lee la entidad para que se puedan cargar los municipios */

    public function lee_entidad()
    {
        $this->reset('municipios');
        if ($this->main_record->entidad_id) {
            $this->entidad = Entidad::findOrFail($this->main_record->entidad_id);
            $this->municipios = $this->entidad->municipios()->orderby('nombre')->get();
        }
    }
    /*+---------------+
    | Guarda Registro |
    +-----------------+
    */

    public function store()
    {
        $this->reset('error_message');

        $this->validate();

        if (!$this->validaCURP($this->main_record->curp)) {
            $this->error_message = 'Revise la CURP, al parecer está mal integrada';
            return false;
        }

        if (!$this->profile) {
            $this->main_record->user_id = Auth::user()->id;
        }

        $this->main_record->save();

        if ($this->ine_anverso) {
            if ($this->ine_anverso_anterior) {
                Storage::delete($this->ine_anverso_anterior);
            }
            $nombre_archivo = 'ine_' . str_pad($this->main_record->id, 3, '0', STR_PAD_LEFT) . '_' . $this->ine_anverso->getClientOriginalName();
            $Image = $this->ine_anverso->storeAs('public/ines', $nombre_archivo);
            $this->main_record->ine_anverso = $Image;
        }

        if ($this->ine_reverso) {
            if ($this->ine_reverso_anterior) {
                Storage::delete($this->ine_reverso_anterior);
            }
            $nombre_archivo = 'ine_' . str_pad($this->main_record->id, 3, '0', STR_PAD_LEFT) . '_' . $this->ine_reverso->getClientOriginalName();
            $Image = $this->ine_reverso->storeAs('public/ines', $nombre_archivo);
            $this->main_record->ine_reverso = $Image;
        }
        $this->main_record->save();
        $message = 'Datos Complementarios Actualizados';
        $this->read_profile();
        $this->show_alert('success', $message);
        $this->closeModal();
        $this->resetInputFields();
        return redirect()->route('dashboard');
        // return redirect()->back(); // This is not working
    }


    // Restaura campos
    public function resetInputFields()
    {
        $this->reset('ine_anverso', 'ine_reverso');
        $this->resetErrorBag();
    }

    public function closeDataUser()
    {
        return redirect()->route('dashboard');
    }
}
