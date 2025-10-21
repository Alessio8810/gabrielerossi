<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingUserDeletion = false;
    public $userToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($userId)
    {
        $this->userToDelete = $userId;
        $this->confirmingUserDeletion = true;
    }

    public function deleteUser()
    {
        if ($this->userToDelete) {
            $user = User::find($this->userToDelete);
            
            // Non permettere di eliminare se stesso
            if ($user && $user->id !== Auth::id()) {
                $user->delete();
                session()->flash('success', 'Utente eliminato con successo.');
            } else {
                session()->flash('error', 'Non puoi eliminare il tuo stesso account.');
            }
        }

        $this->confirmingUserDeletion = false;
        $this->userToDelete = null;
    }

    public function cancelDelete()
    {
        $this->confirmingUserDeletion = false;
        $this->userToDelete = null;
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.user-management', [
            'users' => $users,
        ]);
    }
}
