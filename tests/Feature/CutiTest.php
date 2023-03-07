<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\User;
use App\Models\Cut;

class CutiTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCutiTest()
    {
        $user = User::factory()->create();

        $data = [
            'user_id' => $user->id,
            'start_date' => '2023-03-01',
            'end_date' => '2023-03-03',
            'reason' => 'Sick leave',
            'status' => 'pending'
        ];

        $response = $this->actingAs($user)->post('/api/annual-leaves', $data);

        $response->assertStatus(201);
    }

    public function testGetCutiTestLeaves()
    {
        $response = $this->get('/api/annual-leaves');

        $response->assertStatus(200);
    }

    public function testGetCutiTestLeave()
    {
        $cuti = Cut::factory()->create();

        $response = $this->get('/api/annual-leaves/' . $cuti->id);
        $response->assertStatus(200);
        // Assert that the response body contains the expected data
        $response->assertJson([
            'data' => [
                'id' => $cuti->id,
                'user_id' => $cuti->user_id,
                'start_date' => $cuti->start_date,
                'end_date' => $cuti->end_date,
                'reason' => $cuti->reason,
                'status' => $cuti->status,
                'created_at' => $cuti->created_at,
                'updated_at' => $cuti->updated_at
            ]
        ]);
    }
}
