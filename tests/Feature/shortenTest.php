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
        print("Test pemendekan URL\n");
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
        print("Test redirect pada short URL yang sudah ada\n");
        $this->POST('/', ['url' => 'google.com']);
        $response = $this->GET('/c7b9');
        $response->assertStatus(302);
        $response->assertRedirect('http://google.com');

        print("Test redirect pada short URL yang tidak tersedia\n");
        $response = $this->GET('/randomLink');
        $response->assertSee("404");
    }

    /**
     * Test pembuatan Custom URL.
     *
     * @return void
     */
    public function testCustomUrl() {
        print("Test pembuatan URL custom\n");
        $response = $this->POST('/google', ['url' => 'google.com']);
        $response->assertStatus(200);
        $response->assertJson(['status' => 1]);
        $response = $this->GET('/google');
        $response->assertStatus(302);
        $response->assertRedirect('http://google.com');

        print("Test pembuatan URL custom yang sudah ada\n");
        $response = $this->POST('/google', ['url' => 'facebook.com']);
        $response->assertStatus(200);
        $response->assertJson(['status' => 0]);
        $response = $this->GET('/google');
        $response->assertStatus(302);
        $response->assertRedirect('http://google.com');
    }


}
