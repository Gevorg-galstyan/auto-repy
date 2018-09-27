<?php

namespace App\Services;

class Validator
{
    protected $facebook;

    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
    }

    public function validate($input)
    {
        if (!$this->validateFacebookCallback($input)) {
            return false;
        }

        if (isset($input['entry'][0]['changes'][0]['value']['message']) || !empty($input['entry'][0]['changes'][0]['value']['message'])) {
            $message = $input['entry'][0]['changes'][0]['value']['message'];
        }else{
            $comment_id = $input['entry'][0]['changes'][0]['value']['comment_id'];

            $message = $this->facebook->getComment($comment_id);
        }

        return str_contains(mb_strtolower($message), 'pukkelpop') != false;

    }

    private function validateFacebookCallback($input)
    {
        if (!isset($input['entry']) || !is_array($input['entry'])) {
            return false;
        }

        $entry = $input['entry'][0];
        if (!isset($entry['changes']) || !is_array($entry['changes']) || empty($entry['changes'][0]['value'])) {
            return false;
        }

        $value = $entry['changes'][0]['value'];
        if (!isset($value['verb']) || $value['verb'] != 'add' || !isset($value['item']) || $value['item'] != 'comment') {
            return false;
        }

        if (!isset($value['post_id']) || !isset($value['from']) || !isset($value['from']['id'])) {
            return false;
        }

        if ($value['post_id'] != env('FACEBOOK_NL_POST_ID') && $value['post_id'] != env('FACEBOOK_FR_POST_ID')) {
            return false;
        }


        if ($value['from']['id'] == env('FACEBOOK_PAGE_ID')) {
            return false;
        }

        if (empty($value['comment_id'])) {
            return false;
        }

        return true;
    }
}
