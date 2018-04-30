<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/4/30
 * Time: 10:03
 */
function xml_valid($str){
    $xml_parser = xml_parser_create();
    return xml_parse($xml_parser,$str,true);
}