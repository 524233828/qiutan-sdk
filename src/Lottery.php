<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/5/17
 * Time: 12:25
 */

namespace Qiutan;


use GuzzleHttp\Client;

class Lottery extends Cache
{

    public static function matchIdInterface()
    {
        $cache_time = 600;

        $res = RedisHelper::get(Constant::MATCH_MODIFY_CACHE, self::$redis, function () {
            $client = new Client();

            $url = new Uri(Constant::SDK_DOMAIN);

            $url->withPath("/zq/MatchidInterface.aspx");

            $res = $client->request("GET", (string)$url);

            $str = (string)$res->getBody();

            if(xml_valid($str)){
                return json_encode(
                    simplexml_load_string(
                        $str,
                        'SimpleXMLElement',
                        LIBXML_NOCDATA
                    )
                );
            }else{
                return json_encode([]);
            }
        },$cache_time);

        return json_decode($res, true);
    }
}