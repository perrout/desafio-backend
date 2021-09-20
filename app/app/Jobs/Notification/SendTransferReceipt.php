<?php

namespace App\Jobs\Notification;

use App\Models\Notification;
use App\Services\Notification\NotificationServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTransferReceipt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $notification;
    private $notificationService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Notification $notification, NotificationServiceContract $notificationService)
    {
        $this->notification = $notification;
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->notificationService->send($this->notification->toArray())) {
            $this->notificationService->handleNotitication($this->notification->id);
        }
    }
}
