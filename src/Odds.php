<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/5/17
 * Time: 14:03
 */

namespace Qiutan;


use GuzzleHttp\Client;

class Odds extends Cache
{

    public function odd()
    {
        $cache_time = 60;

        $res = RedisHelper::get(Constant::ODD_CACHE, self::$redis, function () {

            $client = new Client();

            $url = new Uri(Constant::SDK_DOMAIN);

            $url->withPath("/zq/odds.aspx");

            $res = $client->request("GET", (string)$url);

            $str = (string)$res->getBody();

            return $str;

        }, $cache_time);

        return $res;
    }
}