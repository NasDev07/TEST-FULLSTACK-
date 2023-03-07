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

    /**
     * Test creating a new annual leave request
     *
     * @return void
     */
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

        $response = $this->post('/api/annual-leaves', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'user_id',
                'start_date',
                'end_date',
                'reason',
                'status',
                'created_at',
                'updated_at',
            ]
        ]);
    }


    /**
     * Test retrieving all annual leave requests
     *
     * @return void
     */
    public function testGetCutiTestLeaves()
    {
        $cuti = Cut::factory()->count(3)->create();

        $response = $this->get('/api/annual-leaves');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'user_id',
                    'start_date',
                    'end_date',
                    'reason',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
        $response->assertJsonCount(3, 'data');
    }

    /**
     * Test retrieving a single annual leave request
     *
     * @return void
     */
    public function testGetCutiTestLeave()
    {
        $cuti = Cut::factory()->create();

        $response = $this->get('/api/annual-leaves/' . $cuti->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'user_id',
                'start_date',
                'end_date',
                'reason',
                'status',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    /**
     * Test validation when creating a new annual leave request
     *
     * @return void
     */
    public function testCreateCutiTestLeaveValidation()
    {
        $response = $this->post('/api/annual-leaves', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'user_id',
            'start_date',
            'end_date',
            'reason',
            'status',
        ]);
    }
}
