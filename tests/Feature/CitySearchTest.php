<?php

namespace Tests\Feature;

use App\Http\Livewire\CitySearch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CitySearchTest extends TestCase
{
    /** @test */
    public function main_page_contains_city_search_livewire_component()
    {
        $this->get('/')
            ->assertSeeLivewire('city-search');
    }

    /** @test */
    public function search_dropdown_searches_correctly_if_city_exists()
    {
        Livewire::test(CitySearch::class)
            ->assertDontSee('Toronto')
            ->set('city', 'Toronto')
            ->assertSee('Toronto');
    }

    /** @test */
    public function search_dropdown_shows_message_if_no_song_exists()
    {
        Livewire::test(CitySearch::class)
            ->set('city', 'yhknxdrnoa')
            ->assertSee('No results found for');
    }
}
