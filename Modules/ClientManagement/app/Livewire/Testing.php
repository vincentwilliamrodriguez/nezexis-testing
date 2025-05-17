<?php

namespace Modules\ClientManagement\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Modules\ClientManagement\Models\MainCompany;
use Modules\ClientManagement\Models\Status;

class Testing extends Component
{
    public $status = 1;
    public $location = [];

    public $sampleComp;
    public $selectOptions;
    public $locationOptions = [
        'country' => [
            [ 'id' => 'philippines', 'name' => 'Philippines' ]
        ],
        'region' => [],
        'province' => [],
        'city' => [],
        'barangay' => [],
    ];


    public function mount() {
        $this->sampleComp = MainCompany::find(1);
        $this->selectOptions = Status::all()->map(fn($status) => [
            'id' => $status->id,
            'name' => ucfirst($status->name),
        ])->toArray();
    }

    public function render()
    {
        return view('clientmanagement::livewire.testing');
    }

    public function updated($property, $value) {
        $locProps = [
            'country',
            'region',
            'province',
            'city',
            'barangay',
        ];
        $locShorthand = [
            'country' => null,
            'region' => 'reg',
            'province' => 'prov',
            'city' => 'citymun',
            'barangay' => 'brgy',
        ];
        $locDatabases = [
            'country' => null,
            'region' => 'refregion',
            'province' => 'refprovince',
            'city' => 'refcitymun',
            'barangay' => 'refbrgy',
        ];


        if (str_contains($property, 'location.')) {
            $curLoc = explode('location.', $property)[1];

            // Excludes street address & zipcode
            if (!in_array($curLoc, $locProps)) {
                return;
            }

            // Excludes barangay
            $locIndex = array_search($curLoc, $locProps);

            if (($locIndex + 1) >= count($locProps)) {
                return;
            }

            // Resets every location field after the edited one
            for ($i = $locIndex + 1; $i < count($locProps); $i++) {
                $this->location[$locProps[$i]] = null;
                $this->locationOptions[$locProps[$i]] = [];
            }

            // Logic for calculating next location's options
            $nextLoc = $locProps[$locIndex + 1];

            if ($nextLoc) {
                $nextLocCodeName = $locShorthand[$nextLoc] . 'Code';
                $nexLocDescName = $locShorthand[$nextLoc] . 'Desc';
                $locQuery = DB::table($locDatabases[$nextLoc]);


                if ($curLoc !== 'country') {
                    $curLocCodeName = $locShorthand[$curLoc] . 'Code';
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
        $this->sampleComp->status = $this->status;
        $this->sampleComp->save();
    }
}
