<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function transaction_can_be_created()
    {
        $employee = Employee::factory()->create();

        $data = [
            'employee_id' => $employee->id,
            'hours' => rand(1, 12)
        ];
        $res = $this->post('/api/transaction/create', $data);

        $res->assertStatus(201);
        $this->assertTrue(Transaction::count() == 1);
    }

    /** @test */
    public function payment_sum_is_returning()
    {
        $this->seed();
        $employeeId = Transaction::inRandomOrder()->firstOrFail()->employee->id;
        $transactionSum = Transaction::where('employee_id', $employeeId)->sum('payment');

        $res = $this->get('/api/transaction/index');
        $res->assertOk();
        $this->assertTrue($res->collect()->toArray()[$employeeId] == $transactionSum);
    }

    /** @test */
    public function transaction_is_conducting()
    {
        $this->seed();
        $transaction = Transaction::inRandomOrder()->first();
        $res = $this->patch('/api/transaction/conduct');

        $res->assertStatus(201);
        $updatedTransaction = Transaction::where('id', $transaction->id)->firstOrFail();
        $this->assertTrue($transaction->employee_id == $updatedTransaction->employee_id);
        $this->assertTrue($transaction->hours == $updatedTransaction->hours);
        $this->assertFalse($transaction->status == $updatedTransaction->status);
    }

    /** @test */
    public function transaction_creating_should_fail_when_no_employee_id_provided()
    {
        $data = [
            'hours' => rand(1, 12)
        ];
        $res = $this->postJson('/api/transaction/create', $data);

        $res->assertStatus(422);
    }

    /** @test */
    public function transaction_creating_should_fail_when_no_hours_provided()
    {
        $employee = Employee::factory()->create();

        $data = [
            'employee_id' => $employee->id,
        ];
        $res = $this->postJson('/api/transaction/create', $data);

        $res->assertStatus(422);
    }

}
