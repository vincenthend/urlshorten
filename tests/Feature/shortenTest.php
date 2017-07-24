<?php

namespace Tests\Feature;

use App\Http\Controllers\ShortenerController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class shortenTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * Test pemendekan URL.
     *
     * @return void
     */
    public function testShortenUrl() {
        $response = $this->POST('/', ['url' => 'google.com']);
        $response->assertStatus(200);
        $response->assertJson(['shortUrl' => 'c7b9']);
    }

    /**
     * Test normalisasi(redirect) dari URL yang dipendekkan.
     *
     * @return void
     */
    public function testNormalizeUrl() {
        $response = $this->GET('/c7b9');
        $response->assertStatus(302);
        $response->assertRedirect('http://google.com');

        //TODO : Test error 404
    }

    /**
     * Test pembuatan Custom URL.
     *
     * @return void
     */
    public function testCustomUrl() {
        print("Testing custom URL making (available)");
        $response = $this->POST('/google', ['url' => 'google.com']);
        $response->assertStatus(200);
        $response->assertJson(['status' => 1]);
        $response = $this->GET('/google');
        $response->assertStatus(302);
        $response->assertRedirect('http://google.com');

        print("Testing custom URL making (unavailable)");
        $response = $this->POST('/google', ['url' => 'facebook.com']);
        $response->assertStatus(200);
        $response->assertJson(['status' => 0]);
        $response = $this->GET('/google');
        $response->assertStatus(302);
        $response->assertRedirect('http://google.com');
    }


}
