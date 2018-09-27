<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




//use Illuminate\Support\Facades\Redis;
//Route::get('/', function() {
//    // CHANGE default redis db in settings to 1
//    // CHANGE VISIBILITY OF FACEBOOK.PHP fields post_id & comment_id to public, or define getters for this fields
//    // CHANGE VISIBILITY OF SENDREPLY.PHP field $facebook to public, or define getters for this fields
//    $completed = [];
//    $keys = Redis::keys("horizon*");
//    foreach ($keys as $key) {
//        try {
//            $row = Redis::hGetAll($key);
//        } catch (\Exception $e) {
//            continue;
//        }
//
//        if (isset($row['status']) && $row['status'] == 'completed') {
//            $payload = unserialize(json_decode($row['payload'], JSON_UNESCAPED_UNICODE)['data']['command'])->facebook;
//            if ($payload->post_id[0] == 3)
//                $completed[] = [
//                    'completed_at' => \Carbon\Carbon::createFromTimestamp($row['completed_at'])->toDateTimeString(),
//                    'comment_id' => $payload->comment_id,
//                    'post_id' => $payload->post_id,
//                ];
//        }
//    }
//    $completed = collect($completed)->sortByDesc('completed_at')->values();
//    // dd($completed);
//    $result = [];
//    foreach ($completed as $c) {
//        $result[] = 'https://facebook.com/' . $c['comment_id'];
//    }
//    // \File::put(public_path('result.json'), json_encode($result));
//    return $result;
//});
