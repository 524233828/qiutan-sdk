<?php

/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/4/30
 * Time: 9:45
 */

namespace Qiutan;

use GuzzleHttp\Client;

class Match
{

    /**
     * @param null $date
     * @param null $sclassId
     * @return mixed
     */
    public static function get($date = null, $sclassId = null)
    {
        $client = new Client();

        $url = new Uri(Constant::SDK_DOMAIN);

        $url->withPath("/zq/BF_XML.aspx");

        $data = [];
        if(!empty($date)){
            $data["date"] = $date;
        }

        if(empty($date) && !empty($sclassId)){
            $data["sclassid"] = $sclassId;
        }

        $url->withQuery($data);

        $res = $client->request("GET", (string)$url);

        return json_decode(
            json_encode(
                simplexml_load_string(
                    (string)$res->getBody(),
                    'SimpleXMLElement',
                    LIBXML_NOCDATA
                )
            )
            ,true
        );
    }

    public static function getById($id)
    {
        $client = new Client();

        $url = new Uri(Constant::SDK_DOMAIN);

        $url->withPath("/zq/BF_XML.aspx");

        $data["id"] = $id;

        $url->withQuery($data);

        $res = $client->request("GET", (string)$url);

        return json_decode(
            json_encode(
                simplexml_load_string(
                    (string)$res->getBody(),
                    'SimpleXMLElement',
                    LIBXML_NOCDATA
                )
            )
            ,true
        );
    }

    public static function modifyRecord()
    {
        $client = new Client();

        $url = new Uri(Constant::SDK_DOMAIN);

        $url->withPath("/zq/ModifyRecord.aspx");

        $res = $client->request("GET", (string)$url);

        return json_decode(
            json_encode(
                simplexml_load_string(
                    (string)$res->getBody(),
                    'SimpleXMLElement',
                    LIBXML_NOCDATA
                )
            )
            ,true
        );
    }
}