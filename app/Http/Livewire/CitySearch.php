<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class CitySearch extends Component
{
    public $city;
    public $searchResults = [];

    protected $queryString = [
        'city' => ['except' => '']
    ];

    private function fetchData($city){
        return Http::get("https://openweathermap.org/data/2.5/find?q={$city}&appid=439d4b804bc8187953eb36d2a8c26a02&units=metric")->json();
    }

    public function mount()
    {
        $data = $this->fetchData($this->city);

        if ( isset($data['list']) ) {
            $this->searchResults = $data['list'];
        }
    }

    public function updatedCity($newValue){

        if (strlen($newValue) < 3) {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = $this->fetchData($newValue)['list'];
    }

    public function render(){


        return view('livewire.city-search');
    }
}
