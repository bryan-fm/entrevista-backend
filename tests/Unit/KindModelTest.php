<?php

namespace Tests\Unit\Models;

use App\Models\Kind;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

class KindModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_kind_with_mass_assignment()
    {
        $kind = Kind::create([
            'description' => 'Test Kind'
        ]);

        $this->assertDatabaseHas('kinds', [
            'description' => 'Test Kind'
        ]);
    }

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $kind = new Kind();

        $this->assertEquals(['description'], $kind->getFillable());
    }

    /** @test */
    public function it_validates_description_as_required_string_max_255()
    {
        $data = [];
        $validator = Validator::make($data, Kind::rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('description', $validator->errors()->toArray());

        $data = ['description' => str_repeat('a', 256)];
        $validator = Validator::make($data, Kind::rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('description', $validator->errors()->toArray());

        $data = ['description' => 'Valid Description'];
        $validator = Validator::make($data, Kind::rules());
        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function it_uses_the_correct_table_name()
    {
        $this->assertEquals('kinds', (new Kind())->getTable());
    }
}