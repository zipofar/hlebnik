<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupportTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSupportWithEmptySearch()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('search');
    }

    public function testSupportWithFillSearch()
    {
        $response = $this->get('/?search=no+sound');

        $response->assertStatus(200);
        $response->assertSeeText('the sound');
    }
}
