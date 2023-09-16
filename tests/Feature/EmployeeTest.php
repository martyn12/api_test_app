<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $res->assertOk();
    }
}
