<?php

namespace Modules\ClientManagement\Livewire;

use Livewire\Component;
use Modules\ClientManagement\Models\MainCompany;
use Modules\ClientManagement\Models\Status;

class Testing extends Component
{
    public $status = 1;
    public $sampleComp;

    public function mount() {
        $this->sampleComp = MainCompany::find(1);
    }

    public function render()
    {
        $options = Status::all()->map(fn($status) => [
            'id' => $status->id,
            'name' => ucfirst($status->name),
        ])->toArray();

        return view('clientmanagement::livewire.testing', compact('options'));
    }

    public function save() {
        $this->sampleComp->status = $this->status;
        $this->sampleComp->save();
    }
}
