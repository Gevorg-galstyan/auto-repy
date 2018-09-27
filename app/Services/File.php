<?php

namespace App\Services;

class File
{
	public static function read()
	{
		$contents = file_get_contents(public_path(env('USERS_FILE_PATH')));
		if ($contents !== false) {
			return explode(PHP_EOL, $contents);
		}

		Logger::log('users.txt not found');
		return [];
	}

	public static function write($data)
	{
		$fh = fopen(public_path(env('USERS_FILE_PATH')), 'a');
		flock($fh, LOCK_EX);
		fwrite($fh, $data . PHP_EOL);
		flock($fh, LOCK_UN);
	}
}