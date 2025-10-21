<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use App\Models\CarModel;
use Livewire\Component;

class CarModelForm extends Component
{
    public $modelId = null;
    public $brand_id = '';
    public $name = '';
    public $isEditing = false;

    protected function rules()
    {
        $rules = [
            'brand_id' => ['required', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
        ];

        // Validazione univocità: stesso nome solo se brand diverso
        if ($this->isEditing) {
            $rules['name'][] = 'unique:car_models,name,' . $this->modelId . ',id,brand_id,' . $this->brand_id;
        } else {
            $rules['name'][] = 'unique:car_models,name,NULL,id,brand_id,' . $this->brand_id;
        }

        return $rules;
    }

    protected $messages = [
        'brand_id.required' => 'Seleziona un marchio.',
        'brand_id.exists' => 'Il marchio selezionato non è valido.',
        'name.required' => 'Il nome del modello è obbligatorio.',
        'name.unique' => 'Questo modello esiste già per il marchio selezionato.',
    ];

    public function mount($modelId = null)
    {
        if ($modelId) {
            $this->modelId = $modelId;
            $this->isEditing = true;
            $this->loadModel();
        }
    }

    public function loadModel()
    {
        $model = CarModel::findOrFail($this->modelId);
        $this->brand_id = $model->brand_id;
        $this->name = $model->name;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'brand_id' => $this->brand_id,
            'name' => $this->name,
        ];

        if ($this->isEditing) {
            $model = CarModel::findOrFail($this->modelId);
            $model->update($data);
            
            session()->flash('success', 'Modello aggiornato con successo.');
        } else {
            CarModel::create($data);
            
            session()->flash('success', 'Modello creato con successo.');
        }

        return redirect()->route('admin.models');
    }

    public function render()
    {
        $brands = Brand::active()->orderBy('name')->get();
        
        return view('livewire.admin.car-model-form', [
            'brands' => $brands,
        ]);
    }
}
