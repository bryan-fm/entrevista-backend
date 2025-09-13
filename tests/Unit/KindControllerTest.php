<?php
namespace Tests\Feature;

use App\Models\Kind;
use App\Models\User;
use Tests\TestCase;
use App\Services\KindService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;

class KindControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Limpa qualquer mock anterior
        Mockery::close();
    }

    public function testIndexReturnsPaginatedKinds()
    {
        $user = User::factory()->create();

        $kindsCollection = new Collection([
            ['id'=>1,'description'=>'Test Kind']
        ]);

        $paginated = new LengthAwarePaginator($kindsCollection, $kindsCollection->count(), 10, 1);

        $serviceMock = Mockery::mock(KindService::class);
        $serviceMock->shouldReceive('paginateKinds')->once()->andReturn($paginated);
        $this->app->instance(KindService::class, $serviceMock);

        $response = $this->actingAs($user, 'sanctum')
                         ->getJson('/api/kinds');
    

        $response->assertStatus(200)
                 ->assertJsonPath('data.0.description', 'Test Kind');
    }

    public function testFindReturnsKind()
    {
        $user = User::factory()->create();
        $kind = Kind::factory()->create();

        $serviceMock = Mockery::mock(KindService::class);
        $serviceMock->shouldReceive('findKindById')->once()->andReturn($kind);
        $this->app->instance(KindService::class, $serviceMock);

        $response = $this->actingAs($user, 'sanctum')
                         ->getJson("/api/kinds/{$kind->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('id', $kind->id);
    }

    public function testStoreReturnsCreatedKind()
    {
        $user = User::factory()->create();

        $data = ['description'=>'Test'];

        $createdkind = new kind($data);
        $createdkind->id = 1;

        $serviceMock = Mockery::mock(KindService::class);
        $serviceMock->shouldReceive('createKind')->once()->andReturn($createdkind);
        $this->app->instance(kindService::class, $serviceMock);

        $response = $this->actingAs($user, 'sanctum')
                    ->postJson('/api/kinds/create', $data);


        $response->assertStatus(201)
                 ->assertJsonPath('id', 1)
                 ->assertJsonPath('description', 'Test');
    }

        public function testUpdateReturnsUpdatedKind()
    {
        $user = User::factory()->create();
        
        $updatedData = ['description' => 'Scheduled'];

        $updatedkind = new Kind($updatedData);
        $updatedkind->id = 99;

        $serviceMock = Mockery::mock(KindService::class);
        $serviceMock->shouldReceive('updateKind')->once()->andReturn($updatedkind);
        $this->app->instance(KindService::class, $serviceMock);

        $this->app->instance(KindService::class, $serviceMock);

        $updatedResoponse = $this->actingAs($user, 'sanctum')
                ->postJson('/api/kinds/update/' . $updatedkind->id, $updatedData);

        $updatedResoponse->assertStatus(200)
            ->assertJsonPath('id', 99)
            ->assertJsonPath('description', 'Scheduled');
    }
}
