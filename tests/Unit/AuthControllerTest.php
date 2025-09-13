<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterEndpoint()
    {
        $data = ['name'=>'Bryan','email'=>'bryan@test.com','password'=>'12345678'];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'user' => ['id','name','email','created_at','updated_at'],
                     'token'
                 ]);
    }

    public function testLoginEndpointWithValidCredentials()
    {
        $password = '12345678';
        $user = User::factory()->create(['password'=>bcrypt($password)]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'user' => ['id','name','email','created_at','updated_at'],
                     'token'
                 ]);
    }

    public function testLoginEndpointWithInvalidCredentials()
    {
        $user = User::factory()->create(['password'=>bcrypt('12345678')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Credenciais inválidas'
            ]);
    }

}
