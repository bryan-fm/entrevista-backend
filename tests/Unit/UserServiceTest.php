<?php

namespace Tests\Unit;

use App\Exceptions\User\UserCreationException;
use App\Exceptions\User\UserNotFoundException;
use Tests\TestCase;
use App\Services\UserService;
use App\Repositories\UserRepository;
use App\Models\User;
use Mockery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class UserServiceTest extends TestCase
{
    protected $service;
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(UserRepository::class);
        $this->service = new UserService($this->repository);
    }

    public function testCreateUserSuccess()
    {
        $data = ['name'=>'Bryan','email'=>'bryan@test.com','password'=>'12345678'];

        $userMock = new User(['name'=>'Bryan','email'=>'bryan@test.com']);

        $this->repository->shouldReceive('create')
            ->once()
            ->andReturn($userMock);

        $result = $this->service->createUser($data);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('Bryan', $result->name);
    }

    public function testCreateUserThrowsException()
    {
        $this->repository->shouldReceive('create')
            ->once()
            ->andThrow(\Exception::class);

        $this->expectException(UserCreationException::class);

        $this->service->createUser(['name'=>'X','email'=>'x@test.com','password'=>'123']);
    }

    public function testFindUserByIdSuccess()
    {
        $userMock = new User(['name'=>'Bryan','email'=>'bryan@test.com']);

        $this->repository->shouldReceive('findById')
            ->once()
            ->andReturn($userMock);

        $result = $this->service->findUserById(1);

        $this->assertEquals('Bryan', $result->name);
    }

    public function testFindUserByIdThrowsException()
    {
        $this->repository->shouldReceive('findById')
            ->once()
            ->andThrow(ModelNotFoundException::class);

        $this->expectException(UserNotFoundException::class);

        $this->service->findUserById(999);
    }
}
