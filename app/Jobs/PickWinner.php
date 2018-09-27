<?php

namespace App\Jobs;

use App\Services\Facebook;
use App\Services\Logger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PickWinner implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $facebook;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->facebook->pickWinner();

        SendReply::dispatch($this->facebook)->onQueue('send-replies');
    }
}
