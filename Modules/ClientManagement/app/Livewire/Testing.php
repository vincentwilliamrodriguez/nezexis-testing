<?php

namespace Modules\ClientManagement\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Modules\ClientManagement\Models\MainCompany;
use Modules\ClientManagement\Models\Status;

class Testing extends Component
{
    public $item = [];
    public $location = [];

    public $sampleComp;
    public $clientTypeOptions = [
        [ 'id' => 'company', 'name' => 'Company' ],
        [ 'id' => 'individual', 'name' => 'Individual' ]
    ];
    public $statusOptions;

    public $locProps = [];
    public $locationOptions = [
        'country' => [
            [ 'id' => 'philippines', 'name' => 'Philippines' ]
        ],
        'region' => [],
        'province' => [],
        'city' => [],
        'barangay' => [],
    ];
    public $locConfig = [
        'country' => [
            'shorthand' => '',
            'database' => '',
        ],
        'region' => [
            'shorthand' => 'reg',
            'database' => 'refregion',
        ],
        'province' => [
            'shorthand' => 'prov',
            'database' => 'refprovince',
        ],
        'city' => [
            'shorthand' => 'citymun',
            'database' => 'refcitymun',
        ],
        'barangay' => [
            'shorthand' => 'brgy',
            'database' => 'refbrgy',
        ],
    ];



    public $validationAttributes = [
        'item.name'         => 'Name',
        'item.client_type'  => 'Client Type',
        'item.status'       => 'Status',
        'item.email'        => 'Email Address',
        'item.mobile'       => 'Mobile Number',

        'location.country' => 'Country',
        'location.region' => 'Region',
        'location.province' => 'Province',
        'location.city' => 'City/Municipality',
        'location.barangay' => 'Barangay',
        'location.street_add' => 'Street Address',
        'location.zipcode'  => 'Zipcode',
    ];




    public function mount() {
        $this->sampleComp = MainCompany::find(1);
        $this->statusOptions = Status::all()->map(fn($status) => [
            'id' => $status->id,
            'name' => ucfirst($status->name),
        ])->toArray();

        $this->locProps = array_keys($this->locConfig);
    }

    public function render()
    {
        return view('clientmanagement::livewire.testing');
    }

    protected function rules() {
        // Validation for client info & some location fields
        $rules = [
            'item.name'         => ['required', 'string', 'max:40'],
            'item.client_type'  => ['required', 'string', 'in:company,individual'],
            'item.status'       => ['required', 'string', 'exists:refstat,id'],
            'item.email'        => ['nullable', 'email', 'max:30'],
            'item.mobile'       => ['nullable', 'regex:/^09\d{9}$/'],

            'location.street_add' => ['required', 'string', 'max:40'],
            'location.zipcode'  => ['required', 'digits:4'],
        ];

        // Validation for location fields with ID
        foreach ($this->locConfig as $loc => $config) {
            if (!empty($config['database'])) {
                $databaseName = $config['database'];
                $codeName = $config['shorthand'] . 'Code';
                $rules["location.$loc"] = ['required', 'string', "exists:$databaseName,$codeName"];
            } else {
                $rules["location.$loc"] = ['required', 'string'];
            }
        }

        return $rules;
    }

    protected function messages() {
        return [
            'item.mobile' => 'The Mobile Number field must be in the format 09XXXXXXXXX',
        ];
    }


    public function updated($property, $value) {

        // For filling the location dropdowns' options
        if (str_contains($property, 'location.')) {
            $curLoc = explode('location.', $property)[1];
            $this->populateLocationDropdowns($curLoc, $value);
        }


        // For validating each property live
        if (in_array($property, array_keys($this->validationAttributes))) {
            $this->validateOnly($property);
        }
    }

    
    private function populateLocationDropdowns($curLoc, $value) {
        // Excludes street address & zipcode
        if (!in_array($curLoc, $this->locProps)) {
            return;
        }

        // Excludes barangay
        $locIndex = array_search($curLoc, $this->locProps);

        if (($locIndex + 1) >= count($this->locProps)) {
            return;
        }

        // Resets every location field after the edited one
        for ($i = $locIndex + 1; $i < count($this->locProps); $i++) {
            $this->location[$this->locProps[$i]] = null;
            $this->locationOptions[$this->locProps[$i]] = [];
        }

        // Logic for calculating next location's options
        $nextLoc = $this->locProps[$locIndex + 1];

        if ($nextLoc && ($this->location[$curLoc] !== '')) {
            $nextLocCodeName = $this->locConfig[$nextLoc]['shorthand'] . 'Code';
            $nexLocDescName = $this->locConfig[$nextLoc]['shorthand'] . 'Desc';
            $locQuery = DB::table($this->locConfig[$nextLoc]['database']);


            if ($curLoc !== 'country') {
                $curLocCodeName = $this->locConfig[$curLoc]['shorthand'] . 'Code';
                $locQuery = $locQuery->where($curLocCodeName, $value);
            }

            if (in_array($nextLoc, ['city', 'barangay'])) {
                $locQuery = $locQuery->orderBy($nexLocDescName, 'asc');
            }

            $this->locationOptions[$nextLoc] = $locQuery->get()->map(fn($loc) => [
                'id' => $loc->$nextLocCodeName,
                'name' => $this->titleCaseLocation($loc->$nexLocDescName),
            ])->toArray();
        }
    }

    private function titleCaseLocation($text) {
        $text = strtolower($text);
        $words = explode(' ', $text);

        $allCaps = ['ncr', 'ncr,', 'car', 'armm', 'calabarzon', 'mimaropa', 'soccsksargen', 'i', 'ii', 'iii', 'iv', 'iv-a', 'iv-b', 'v', 'iv', 'vi', 'vii', 'viii', 'ix', 'x', 'xi', 'xii', 'xiii'];
        $lowercase = ['de', 'del', 'la', 'sa', 'ng', 'at', 'in', 'of'];


        foreach ($words as $key => $word) {
            $leftParen = '';
            $rightParen = '';
            $actualWord = $word;

            if (strpos($word, '(') === 0) {
                $leftParen = '(';
                $actualWord = substr($word, 1);
            }

            if (substr($word, -1) === ')') {
                $rightParen = ')';
                $actualWord = substr($actualWord, 0, -1);
            }


            if (in_array(strtolower($actualWord), $allCaps)) {
                $actualWord = strtoupper($actualWord);
            }
            elseif (in_array($actualWord, $lowercase) && $key !== 0) {
                $actualWord = strtolower($actualWord);
            }
            else {
                $actualWord = ucfirst($actualWord);
            }


            $words[$key] = $leftParen . $actualWord . $rightParen;
        }

        return implode(' ', $words);
    }

    public function save() {
        $this->validate();

        $this->sampleComp->status = $this->item['status'];
        $this->sampleComp->save();
    }
}
