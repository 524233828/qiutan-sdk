<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/4/30
 * Time: 10:07
 */

namespace Qiutan;

use GuzzleHttp\Client;

class League extends Cache
{
    public static function get()
    {
        $cache_time = 3600;
        $res = RedisHelper::get(Constant::LEAGUE_CACHE, self::$redis, function (){
            $client = new Client();

            $url = Constant::SDK_DOMAIN . "/zq/League_XML.aspx";

            $res = $client->request("GET", $url);

            return json_encode(
                simplexml_load_string(
                    (string)$res->getBody(),
                    'SimpleXMLElement',
                    LIBXML_NOCDATA
                )
            );
        }, $cache_time);

        return json_decode($res, true);

    }
}