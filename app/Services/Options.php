<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class Options
{
    private $options = [
        ['name' => '01-1.png'],
        ['name' => '01-2.png'],
        ['name' => '01-4.png'],
        ['name' => '01-4.png'],
        ['name' => '02-1.png'],
        ['name' => '02-2.png'],
        ['name' => '02-3.png'],
        ['name' => '02-4.png'],
        ['name' => '02-5.png'],
        ['name' => '03-1.png'],
        ['name' => '03-2.png'],
        ['name' => '03-3.png'],
        ['name' => '03-4.png'],
        ['name' => '03-5.png'],
        ['name' => '04-1.png'],
        ['name' => '04-2.png'],
        ['name' => '04-3.png'],
        ['name' => '04-4.png'],
        ['name' => '04-5.png'],
    ];

    public function get($index)
    {
        return $this->options[$index] ?? null;
    }

    public function random($user_id)
    {
        if (Redis::exists("app:last_prize:$user_id")) {
            $option = (int) Redis::get("app:last_prize:$user_id");
        } else {
            $option = mt_rand(0, count($this->options) - 1);
            Redis::set("app:last_prize:$user_id", $option);
        }

        return $option;
    }
}
