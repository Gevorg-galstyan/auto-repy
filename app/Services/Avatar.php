<?php

namespace App\Services;

use Intervention\Image\ImageManager;

class Avatar
{
    protected $imageManager;
    protected $options;
    protected $facebook;

    const WIDTH = 1200;
    const HEIGHT = 1200;

    public function __construct(Options $options, Facebook $facebook)
    {
        $this->imageManager = new ImageManager(array('driver' => 'imagick'));
        $this->options = $options;
        $this->facebook = $facebook;
    }

    public function prepare($option, $user_id, $post_id)
    {

        $option = $this->options->get($option);
        $avatarUrl = $this->facebook->getAvatarUrl($user_id);
        $result = 'images/avatars/' . $user_id . '_' . $post_id . '.png';

        $avatar = $this->imageManager->make($avatarUrl)->fit(self::WIDTH, self::HEIGHT);
        $canvas = $this->imageManager->canvas(self::WIDTH, self::HEIGHT);
        $template = $this->imageManager
            ->make(public_path('images/templates/'. ($post_id == env('FACEBOOK_NL_POST_ID') ? 'nl/' : 'fr/') . $option['name']));
        $canvas->insert($avatar, 'top-left', 0, 0);
        $canvas->insert($template, 'top-left', 0, 0);

        $canvas->save(public_path($result));
        return $result;
    }
}
