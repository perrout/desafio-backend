<?php

namespace Tests\Unit;

use App\Jobs\Transaction\ProcessTransfer;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\TestCase;

class ProccessTransferTest extends TestCase
{
    public function testProcessTransfer()
    {
        Queue::fake();

        Queue::assertNotPushed(ProcessTransfer::class);
    }
}
