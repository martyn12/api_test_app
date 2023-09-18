<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function employee_can_be_created()
    {
        $data = [
            'email' => 'example@example1.com',
            'password' => 'examplePass'
        ];

        $res = $this->post('/api/employee/create', $data);
        $res->assertStatus(201);

        $this->assertTrue(Employee::count() > 0);
    }

    /** @test */
    public function should_fail_when_no_email_provided()
    {
        $data = [
            'password' => 'examplePass'
        ];
        $res = $this->postJson('/api/employee/create', $data);
        $res->assertStatus(422);
    }

    /** @test */
    public function should_fail_when_string_as_email_provided()
    {
        $data = [
            'email' => 'some_string',
            'password' => 'examplePass'
        ];
        $res = $this->postJson('/api/employee/create', $data);
        $res->assertStatus(422);
    }

    /** @test */
    public function should_fail_when_no_password_provided()
    {
        $data = [
            'email' => 'example@example1.com',
        ];
        $res = $this->postJson('/api/employee/create', $data);
        $res->assertStatus(422);
    }

    /** @test */
    public function should_fail_when_existing_email_provided()
    {
        Employee::factory([
            'email' => 'test@test.com',
            'password' => Hash::make(12345678)
        ])->create();

        $data = [
            'email' => 'test@test.com',
            'password' => 'helloPaws'
        ];
        $res = $this->postJson('/api/employee/create', $data);
        $res->assertStatus(422);
    }
}
