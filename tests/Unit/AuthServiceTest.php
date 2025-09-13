<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Services\AuthService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AuthService();
    }

    public function testRegisterCreatesUserAndReturnsToken()
    {
        $data = ['name'=>'Bryan','email'=>'bryan@test.com','password'=>'12345678'];

        $result = $this->service->register($data);

        $this->assertInstanceOf(User::class, $result['user']);
        $this->assertNotEmpty($result['token']);
        $this->assertTrue(Hash::check('12345678', $result['user']->password));
    }

    public function testLoginReturnsTokenWithValidCredentials()
    {
        $password = '12345678';
        $user = User::factory()->create(['password'=>Hash::make($password)]);

        $result = $this->service->login([
            'email' => $user->email,
            'password' => $password
        ]);

        $this->assertEquals($user->id, $result['user']->id);
        $this->assertNotEmpty($result['token']);
    }

    public function testLoginThrowsExceptionWithInvalidCredentials()
    {
        $user = User::factory()->create(['password'=>Hash::make('12345678')]);

        $this->expectException(HttpResponseException::class);

        $this->service->login([
            'email' => $user->email,
            'password' => 'wrongpassword'
        ]);
    }

}
