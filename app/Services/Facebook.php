<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class Facebook
{

    protected $options;
    public $comment_id;
    public $post_id;
    protected $user_id;
    protected $user_name;
    protected $option;

    public function __construct(Options $options)
    {
        $this->options = $options;
    }

    public function setData($input) {
        $this->post_id    = $input['entry'][0]['changes'][0]['value']['post_id'];
        $this->comment_id = $input['entry'][0]['changes'][0]['value']['comment_id'];
        $this->user_id    = $input['entry'][0]['changes'][0]['value']['from']['id'];
        $names            = explode(' ', $input['entry'][0]['changes'][0]['value']['from']['name']);
        $lastname         = strtoupper(end($names));
        $this->user_name  = strlen($lastname) > 18 ? substr($lastname, 0, 18) : $lastname;
        $this->option     = $this->options->random($this->user_id);

        Logger::log([$this->post_id, $this->user_id, $this->user_name, $this->option, $this->comment_id]);

        $file = File::read();
        if (in_array($this->comment_id, $file)) {
            return false;
        }

        File::write($this->comment_id);
        return true;
    }

    public function getCommentId()
    {
        return $this->comment_id;
    }

    public function getPostId()
    {
        return $this->post_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUserName()
    {
        return $this->user_name;
    }

    public function getOption()
    {
        return $this->option;
    }

    public function getAvatarUrl($user_id)
    {
        return env('FACEBOOK_API_URL') . $user_id . '/picture?width=1200&height=1200';
    }

    public function getComment($comment_id)
    {
        $result = file_get_contents(env('FACEBOOK_API_URL') . $comment_id . '?fields=message&access_token=' . env('FACEBOOK_TOKEN'));
        if ($result) {
            $result = json_decode($result, true);
            if ($result && isset($result['message'])) {
                return $result['message'];
            }
        }
        return null;
    }

    public function postReply($file_path)
    {
        $outcome_url = env('FACEBOOK_RESPONSE_DOMAIN') . $file_path . '?t=1';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env('FACEBOOK_API_URL') . $this->comment_id . "/comments?access_token=" . env('FACEBOOK_TOKEN'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "attachment_url=$outcome_url");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpcode != 200 || empty(json_decode($server_output, true)['id'])) {
            throw new \Exception('Facebook Api Exception ' . $server_output);
        }
        // Logger::log(['quick', $server_output]);
        curl_close($ch);
    }
}
