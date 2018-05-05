<?php

/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/4/30
 * Time: 9:45
 */

namespace Qiutan;

use GuzzleHttp\Client;

class Match extends Cache
{

    /**
     * @param null $date
     * @param null $sclassId
     * @return mixed
     */
    public static function get($date = null, $sclassId = null)
    {

        $params = "";
        if(!empty($date)){
            $data["date"] = $date;
            $params = $date;
        }

        if(empty($date) && !empty($sclassId)){
            $data["sclassid"] = $sclassId;
            $params = $sclassId;
        }

        $cache_time = 3600;
        $res = RedisHelper::get(Constant::MATCH_CACHE.":{$params}", self::$redis, function () use ($data){
            $client = new Client();

            $url = new Uri(Constant::SDK_DOMAIN);

            $url->withPath("/zq/BF_XML.aspx");

            $url->withQuery($data);

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

        }, $cache_time);

        return json_decode($res, true);
    }

    public static function getById($id)
    {
        $cache_time = 3600;
        $res = RedisHelper::get(Constant::MATCH_CACHE.":{$id}", self::$redis, function () use ($id){
            $client = new Client();

            $url = new Uri(Constant::SDK_DOMAIN);

            $url->withPath("/zq/BF_XML.aspx");

            $data["id"] = $id;

            $url->withQuery($data);

            $res = $client->request("GET", (string)$url);

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

    public static function modifyRecord()
    {

        $cache_time = 90;

        $res = RedisHelper::get(Constant::MATCH_MODIFY_CACHE, self::$redis, function () {
            $client = new Client();

            $url = new Uri(Constant::SDK_DOMAIN);

            $url->withPath("/zq/ModifyRecord.aspx");

            $res = $client->request("GET", (string)$url);

            return json_encode(
                simplexml_load_string(
                    (string)$res->getBody(),
                    'SimpleXMLElement',
                    LIBXML_NOCDATA
                )
            );
        },$cache_time);

        return json_decode($res, true);
    }

    public static function matchChange()
    {
        $cache_time = 10;

        $res = RedisHelper::get(Constant::MATCH_CHANGE_CACHE, self::$redis, function () {
            $client = new Client();

            $url = new Uri(Constant::SDK_DOMAIN);

            $url->withPath("/zq/change.xml");

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