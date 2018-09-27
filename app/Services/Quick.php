<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use App\Jobs\SendReply;
use App\Services\Options;

class Quick
{
    protected $validator;
    protected $facebook;
    protected $options;

    public function __construct(Validator $validator, Options $options, Facebook $facebook)
    {
        $this->validator = $validator;
        $this->options = $options;
        $this->facebook = $facebook;
    }

    public function run($input)
    {
        try {
            if (!$this->validator->validate($input)) {
                return false;
            }

            if (!$this->facebook->setData($input)) {
                return false;
            }

            SendReply::dispatch($this->facebook)->onQueue('send-replies');
        } catch (\Exception $e) {
            Logger::log('Quick Exception');
            Logger::log($e->getMessage());
        }
    }
}
