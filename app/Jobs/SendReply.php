<?php

namespace App\Jobs;

use App\Services\Facebook;
use App\Services\Avatar;
use App\Services\Logger;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Options;

class SendReply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $option;
    protected $user_id;
    protected $post_id;
    protected $user_name;
    protected $comment_id;
    protected $facebook;
    protected $avatarManager;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
        $this->avatarManager = new Avatar(new Options, $this->facebook);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $avatarPath = $this->avatarManager->prepare(
            $this->facebook->getOption(),
            $this->facebook->getUserId(),
            $this->facebook->getPostId(),
            $this->facebook->getUserName()
        );

        $this->facebook->postReply($avatarPath);
    }
}
