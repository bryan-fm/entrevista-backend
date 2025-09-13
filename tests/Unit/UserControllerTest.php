<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;
use Mockery;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Limpa qualquer mock anterior
        Mockery::close();
    }

    public function testIndexReturnsPaginatedUsers()
    {
        $user = User::factory()->create();

        $usersCollection = new Collection([
            ['id'=>1,'name'=>'Bryan','email'=>'bryan@test.com','role'=>'user']
        ]);
        $paginated = new LengthAwarePaginator($usersCollection, $usersCollection->count(), 10, 1);

        $serviceMock = Mockery::mock(UserService::class);
        $serviceMock->shouldReceive('paginateUsers')->once()->andReturn($paginated);
        $this->app->instance(UserService::class, $serviceMock);

        $response = $this->actingAs($user, 'sanctum')
                         ->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonPath('data.0.name', 'Bryan');
    }

    public function testFindReturnsUser()
    {
        $user = User::factory()->create();

        $serviceMock = Mockery::mock(UserService::class);
        $serviceMock->shouldReceive('findUserById')->once()->andReturn($user);
        $this->app->instance(UserService::class, $serviceMock);

        $response = $this->actingAs($user, 'sanctum')
                         ->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('id', $user->id);
    }

    public function testStoreReturnsCreatedUser()
    {
        $authUser = User::factory()->create();

        $data = ['name'=>'Bryan','email'=>'bryan@test.com','password'=>'12345678', 'role' => 'user'];

        $createdUser = new User($data);
        $createdUser->id = 1;

        $serviceMock = Mockery::mock(UserService::class);
        $serviceMock->shouldReceive('createUser')->once()->andReturn($createdUser);
        $this->app->instance(UserService::class, $serviceMock);

        $response = $this->actingAs($authUser, 'sanctum')
                    ->postJson('/api/users/create', $data);


        $response->assertStatus(201)
                 ->assertJsonPath('id', 1)
                 ->assertJsonPath('name', 'Bryan');
    }

        public function testUpdateReturnsUpdatedUser()
    {
        $authUser = User::factory()->create();
        
        $updatedData = ['name'=>'Bryan Updated','email'=>'bryan25@test.com', 'role' => 'user'];

        $updatedUser = new User($updatedData);
        $updatedUser->id = 99;

        $serviceMock = Mockery::mock(UserService::class);
        $serviceMock->shouldReceive('updateUser')->once()->andReturn($updatedUser);
        $this->app->instance(UserService::class, $serviceMock);

        $this->app->instance(UserService::class, $serviceMock);

        $updatedResoponse = $this->actingAs($authUser, 'sanctum')
                ->postJson('/api/users/update/' . $authUser->id, $updatedData);

        $updatedResoponse->assertStatus(200)
            ->assertJsonPath('id', 99)
            ->assertJsonPath('name', 'Bryan Updated');
    }
}
