<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use RefreshDatabase;

    public function testTransferValadations()
    {
        $this->seed();
        $commonUser = User::where('type', 'common')->first();
        $traderUser = User::where('type', 'trader')->first();

        // payer is missing
        $data = [
            "payee_id" => $traderUser->id,
            "value" => 10.00
        ];
        $response = $this->postJson(route('transaction.create'), $data);
        $response->assertStatus(422);

        // payer is trader
        $data = [
            "payer_id" => $traderUser->id,
            "payee_id" => $commonUser->id,
            "value" => 10.00
        ];
        $response = $this->postJson(route('transaction.create'), $data);
        $response->assertStatus(422);

        // payer not found
        $data = [
            "payer_id" => 999,
            "payee_id" => $commonUser->id,
            "value" => 10.00
        ];
        $response = $this->postJson(route('transaction.create'), $data);
        $response->assertStatus(404);

        // payee is missing
        $data = [
            "payer_id" => $commonUser->id,
            "value" => 10.00
        ];
        $response = $this->postJson(route('transaction.create'), $data);
        $response->assertStatus(422);

        // payee not found
        $data = [
            "payer_id" => $commonUser->id,
            "payee_id" => 999,
            "value" => 10.00
        ];
        $response = $this->postJson(route('transaction.create'), $data);
        $response->assertStatus(422);

        // value is missing
        $data = [
            "payer_id" => $commonUser->id,
            "payee_id" => $traderUser->id
        ];
        $response = $this->postJson(route('transaction.create'), $data);
        $response->assertStatus(422);

        // value is greater than the balance
        $data = [
            "payer_id" => $commonUser->id,
            "payee_id" => $traderUser->id,
            "value" => 999999.00
        ];
        $response = $this->postJson(route('transaction.create'), $data);
        $response->assertStatus(422);

        // value is not a number
        $data = [
            "payer_id" => $commonUser->id,
            "payee_id" => $traderUser->id,
            "value" => "10,00"
        ];
        $response = $this->postJson(route('transaction.create'), $data);
        $response->assertStatus(422);
    }

    public function testTransfer()
    {
        $this->seed();
        $commonUser = User::where('type', 'common')->first();
        $traderUser = User::where('type', 'trader')->first();

        // transfer successful
        $data = [
            "payer_id" => $commonUser->id,
            "payee_id" => $traderUser->id,
            "value" => 10.00
        ];
        $response = $this->postJson(route('transaction.create'), $data);
        $response->assertStatus(200);
    }
}
