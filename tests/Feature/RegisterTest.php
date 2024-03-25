<?php

namespace Tests\Feature;

use App\Models\Customers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function test_registration_page_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }
    public function test_new_users_can_register_and_login()
    {
        $one_user = Customers::factory()->create();
        $response = $this->post('/customer/store',[
            'customer_name' => $one_user->customer_name,
            'phone_primary' => $one_user->phone_primary,
            'email' => $one_user->email,
            'password' => $one_user->password,
        ]);
        $response->assertStatus(200);
        $response->dump();
        $response2 = $this->post('/authenticate',[
            'email' => $one_user->email,
            'password' => $one_user->password,
        ]);
        $response2->assertStatus(200);
        $response2->dump();
    }
    public function test_logout()
    {
        $response = $this->get('/signout');
        $response->assertStatus(200);
    }

}
