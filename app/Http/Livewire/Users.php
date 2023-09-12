<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\User;
use App\Models\Round;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Livewire\Traits\CrudTrait;
use App\Http\Livewire\Traits\FuncionesGenerales;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Users extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use CrudTrait;
    use FuncionesGenerales;



    protected $rules = [
        'main_record.first_name'=> 'required|min:5|max:50',
        'main_record.last_name' => 'required|min:3|max:50',
        'main_record.email'     => 'required|email|unique:users',
        'main_record.password'  => 'nullable',
        'main_record.active'    => 'nullable',
        'main_record.phone'     => 'required|numeric',
        'role_id'               => 'required|exists:roles,id',
    ];



    public $error_message   = null;
    public $role_id         = null;
    public $password        = null;
    public $password_confirmation = null;
    public $active          = null;


    public function mount(){
        $this->manage_title = 'Gestionar Usuarios';
        $this->search_label = 'Nombre o Correo Electrónico';
        // $this->view_search  =  null;
        $this->view_form    = 'livewire.users.form';
        $this->view_table   = 'livewire.users.table';
        $this->view_list    = 'livewire.users.list';
        $this->roles        = $this->read_roles();
        $this->allow_create = true;
        $this->main_record  = new User();
        $this->sort         = 'id';
    }

    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */

    public function render(){
        $this->create_button_label = $this->main_record->id ?  'Actualizar Usuario' :  ' Crear Usuario';
        return view('livewire.index', [
            'records' => User::General($this->search)->orderby($this->sort,$this->direction)->paginate($this->pagination),
        ]);
    }


    /*+---------------+
    | Guarda Registro |
    +-----------------+
    */

    public function store(){
        $this->reset('error_message');
        $this->rules['main_record.name']  = $this->main_record->id ? "required|min:3|max:50|unique:users,name,{$this->main_record->id}"
                                                                   : 'required|min:3|max:50|unique:users,name';
        $this->rules['main_record.email'] = $this->main_record->id ? "required|email|unique:users,email,{$this->main_record->id}"
                                                                   : 'required|email|unique:users,email';
        $this->rules['main_record.alias'] = $this->main_record->id ? "required|min:6|max:12|unique:users,alias,{$this->main_record->id}"
                                                                   : 'required|min:6|max:12|unique:users,alias';

        if(!$this->record_id){
            $this->rules['password'] = 'required|min:8|confirmed';
        }


        $this->validate();



        $this->main_record->active = $this->main_record->active ? 1 : 0;


        if(!empty($this->password)){
            $this->main_record->password = Hash::make($this->password);
            $this->main_record->save();
        }

        if($this->main_record->id){
            $roles_assigned = $this->main_record->getRoleNames(); // Returns a collection
            foreach($roles_assigned as $role_assigned){
                $this->main_record->removeRole($role_assigned);
            }
            $this->main_record->assignRole($this->role->name);
        }else{
            $this->main_record->assignRole($this->role->name);
        }

        $this->main_record->save();
        $this->closeModal();
        $this->create_button_label = 'Crear Usuario';
        $this->store_message('Usuario');

    }


    // Restaura campos
    public function resetInputFields(){
        $this->main_record = new User();
        $this->resetErrorBag();
    }


    /*+------------------------------+
      | Lee Registro Editar o Borar  |
      +------------------------------+
    */

    public function edit(User $record){
        $this->main_record  = $record;
        $this->record_id    = $record->id;
        $this->password     = $record->password;
        $roles_assigned = $this->main_record->getRoleNames(); // Returns a collection
        foreach($roles_assigned as $role_assigned){
            $this->role_id = Role::where('name',$role_assigned)->first()->id;
            $this->read_role();
        }


        $this->openModal();
    }

    /*+---------+
      | Lee rol |
      +---------+
    */
    public function read_role(){
        if($this->role_id){
            $this->role = Role::findOrFail($this->role_id);
        }
    }

}

