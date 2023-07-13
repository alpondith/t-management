<?php

namespace App\Jobs;

use App\Mail\TaskMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailOnTaskCreate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $email;
    protected $message;

    public function __construct($e, $m)

    {
        $this->email = $e;
        $this->message = $m;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        dump($this->email, $this->message);
        Mail::to($this->email)->send(new TaskMail($this->message));
    }
}
