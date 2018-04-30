<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/4/30
 * Time: 10:07
 */

namespace Qiutan;

use GuzzleHttp\Client;

class League
{
    public static function get()
    {
        $client = new Client();

        $url = Constant::SDK_DOMAIN . "/zq/League_XML.aspx";

        $res = $client->request("GET", $url);

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