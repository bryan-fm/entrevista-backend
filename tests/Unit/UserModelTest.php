<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function testSoftDeletes()
    {
        $user = User::factory()->create();
        $user->delete();

        $this->assertSoftDeleted($user);
    }

}
