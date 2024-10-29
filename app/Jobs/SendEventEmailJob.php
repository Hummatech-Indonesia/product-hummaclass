<?php

namespace App\Jobs;

use App\Mail\EventEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEventEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $emailContent;
    public $emailAddres;
    /**
     * Create a new job instance.
     */
    public function __construct($emailContent, $emailAddres)
    {
        $this->emailContent = $emailContent;
        $this->emailAddres = $emailAddres;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->emailAddres)->send(new EventEmail($this->emailContent));
    }
}
