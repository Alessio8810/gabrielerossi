<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class BrandForm extends Component
{
    use WithFileUploads;

    public $brandId = null;
    public $name = '';
    public $slug = '';
    public $description = '';
    public $logo = null;
    public $existingLogo = null;
    public $is_active = true;
    public $isEditing = false;

    protected function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:brands,name'],
            'slug' => ['required', 'string', 'max:255', 'unique:brands,slug', 'regex:/^[a-z0-9-]+$/'],
            'description' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'max:2048'], // max 2MB
            'is_active' => ['boolean'],
        ];

        if ($this->isEditing) {
            $rules['name'] = ['required', 'string', 'max:255', 'unique:brands,name,' . $this->brandId];
            $rules['slug'] = ['required', 'string', 'max:255', 'unique:brands,slug,' . $this->brandId, 'regex:/^[a-z0-9-]+$/'];
        }

        return $rules;
    }

    protected $messages = [
        'name.required' => 'Il nome del marchio è obbligatorio.',
        'name.unique' => 'Questo marchio esiste già.',
        'slug.required' => 'Lo slug è obbligatorio.',
        'slug.unique' => 'Questo slug è già utilizzato.',
        'slug.regex' => 'Lo slug può contenere solo lettere minuscole, numeri e trattini.',
        'logo.image' => 'Il logo deve essere un\'immagine.',
        'logo.max' => 'Il logo non può superare i 2MB.',
    ];

    public function mount($brandId = null)
    {
        if ($brandId) {
            $this->brandId = $brandId;
            $this->isEditing = true;
            $this->loadBrand();
        }
    }

    public function loadBrand()
    {
        $brand = Brand::findOrFail($this->brandId);
        $this->name = $brand->name;
        $this->slug = $brand->slug;
        $this->description = $brand->description;
        $this->existingLogo = $brand->logo;
        $this->is_active = $brand->is_active;
    }

    public function updatedName($value)
    {
        // Auto-genera slug solo se non in modifica o se slug è vuoto
        if (!$this->isEditing || empty($this->slug)) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        // Gestione logo
        if ($this->logo) {
            $logoPath = $this->logo->store('brands', 'public');
            $data['logo'] = $logoPath;
        }

        if ($this->isEditing) {
            $brand = Brand::findOrFail($this->brandId);
            
            // Se c'è un nuovo logo, elimina quello vecchio
            if ($this->logo && $brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            
            $brand->update($data);
            
            session()->flash('success', 'Marchio aggiornato con successo.');
        } else {
            Brand::create($data);
            
            session()->flash('success', 'Marchio creato con successo.');
        }

        return redirect()->route('admin.brands');
    }

    public function render()
    {
        return view('livewire.admin.brand-form');
    }
}
