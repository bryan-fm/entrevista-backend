<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new UserRepository();
    }

    public function testCreateUser()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => bcrypt('password123')
        ];

        $user = $this->repository->create($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('testuser@example.com', $user->email);
    }

    public function testFindByIdReturnsUser()
    {
        $user = User::factory()->create();
        $found = $this->repository->findById($user->id);

        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($user->id, $found->id);
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create(['name' => 'Old Name']);
        $updated = $this->repository->update($user, ['name' => 'New Name']);

        $this->assertEquals('New Name', $updated->name);
    }

    public function testAllReturnsCollection()
    {
        User::factory()->count(3)->create();
        $users = $this->repository->all();

        $this->assertCount(3, $users);
    }

    public function testPaginateReturnsPaginator()
    {
        User::factory()->count(15)->create();
        $paginator = $this->repository->paginate(10);

        $this->assertEquals(10, $paginator->count());
        $this->assertInstanceOf(\Illuminate\Contracts\Pagination\LengthAwarePaginator::class, $paginator);
    }
}