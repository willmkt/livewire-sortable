<?php

namespace App\Http\Livewire\Sector;

use App\Models\Sector;
use Livewire\Component;
use Illuminate\Support\Facades\DB;


class SectorIndex extends Component
{
    public $sector_id;
    public $sector_name;
    public $parent_id = null;
    public $parent_name;
    public $construction;
    public $segment;
    public $sectors;
    public $update = false;
    public $show = "";



    protected $listeners = ['parentSelected', 'showModal', 'edit', 'closemodal'];

    public function mount()
    {
    }
      
    public function parentSelected($sectorId)
    {
        $this->parent_id = $sectorId;
        $parent = Sector::find($this->parent_id);
        $this->parent_name = $parent->name;

    }


    private function resetInputFields(){
        $this->sector_id = '';
        $this->sector_name = '';
        $this->parent_name = '';
        $this->parent_id = null;
        $this->update = false;

    }

    public function closemodal()
    {
        // This is to reset our public variables
        $this->resetInputFields();

        // These will reset our error bags
        $this->resetErrorBag();
        $this->resetValidation();
    }


    public function create()
    {

        Sector::updateOrCreate(['id' => $this->sector_id], [
            'name' => $this->sector_name,
            'parent_id' => $this->parent_id,
        ]);

        session()->flash('message', $this->sector_id ? 'Setor atualizado.' : 'Setor criado.');

        $this->emit('closemodal');
        $this->resetInputFields();
    }

    public function edit($id )
    {
        $this->update = true;
        $sector = Sector::findOrFail($id);
        $this->sector_id = $id;
        $this->sector_name = $sector->name;
        $this->parent_id = $sector->parent_id;
    }
     
    public function delete($id)
    {
        $sector = Sector::findOrFail($id);   
        $sector->delete();

        session()->flash('message', 'Setor apagado com sucesso');

    }

    public function updateSectorOrder($sectors)
    {
        $sectors = collect($sectors)->groupBy('value')->map(function($collection){ return $collection[0]; });

        $taskOrder = 1;
        foreach ($sectors as $sector) {
            foreach ($sector['items'] as $child) {
                $child = Sector::findOrFail($child['value']);
                $child->update([
                    'position' => $taskOrder
                ]);
                $taskOrder++;
            }
        }

    }
    public function updateParentOrder($parents)
    {
        foreach ($parents as $index => $parent) {

                $parent = Sector::findOrFail($parent['value']);
                $parent->update([
                    'position' => $index + 1
                ]);


                
        }
        
    }

    public function render()
    {
        $this->sectors = Sector::WhereNull('parent_id')->with('children')
        ->orderBy('position', 'ASC')
        ->get();

        return view('livewire.sector.sector-index',[
            'sectors' => $this->sectors
        ]);
    }
}
