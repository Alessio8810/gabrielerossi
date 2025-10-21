<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserForm extends Component
{
    public $userId = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $isEditing = false;

    protected function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        ];

        if ($this->isEditing) {
            $rules['email'] = ['required', 'email', 'max:255', 'unique:users,email,' . $this->userId];
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
        } else {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        return $rules;
    }

    public function mount($userId = null)
    {
        if ($userId) {
            $this->userId = $userId;
            $this->isEditing = true;
            $this->loadUser();
        }
    }

    public function loadUser()
    {
        $user = User::findOrFail($this->userId);
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $user = User::findOrFail($this->userId);
            $user->name = $this->name;
            $user->email = $this->email;
            
            if ($this->password) {
                $user->password = Hash::make($this->password);
            }
            
            $user->save();
            
            session()->flash('success', 'Utente aggiornato con successo.');
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'email_verified_at' => now(),
            ]);
            
            session()->flash('success', 'Utente creato con successo.');
        }

        return redirect()->route('admin.users');
    }

    public function render()
    {
        return view('livewire.admin.user-form');
    }
}
