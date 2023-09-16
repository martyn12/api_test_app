<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Transaction;
use Database\Factories\EmployeeFactory;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\TransactionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function transaction_can_be_created()
    {
        $this->seed(EmployeeSeeder::class);
        $transaction = Transaction::factory()->create();
        $data['employee_id'] = $transaction->employee_id;
        $data['hours'] = $transaction->hours;
        $res = $this->post('/api/transaction/create', $data);

        $res->assertOk();
    }

    /** @test */
    public function payment_sum_is_returning()
    {
        $this->seed([EmployeeSeeder::class, TransactionSeeder::class]);
        $res = $this->get('/api/transaction/index');

        $res->assertOk();
    }

    /** @test */
    public function transaction_is_conducting()
    {
        $this->seed([EmployeeSeeder::class, TransactionSeeder::class]);
        $transaction = Transaction::inRandomOrder()->first();
        $res = $this->post('/api/transaction/conduct');

        $res->assertOk();

        $updatedTransaction = Transaction::where('id', $transaction->id)->first();

        $this->assertFalse($transaction->status == $updatedTransaction->status);
    }

}
