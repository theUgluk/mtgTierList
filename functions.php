<?php
    function string_cleanr($string) {
        $string = trim($string);
        $string = strip_tags($string);
        $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        $string = str_replace("\n", "", $string);
        $string = trim($string);
        return $string;
    }

    function get_type_data($type){
        if(!file_exists("typeCache/" . $type . ".json")){
            $array = array();
            $url = "http://api.scryfall.com/cards/search?q=" . urlencode("set:eld t:" . $type);
            $res = json_decode(file_get_contents($url), true);
            foreach($res['data'] as $card){
                $array[] = str_replace("//", "", $card['name']);
            }
            file_put_contents("typeCache/" . $type . ".json", json_encode($array));
            return $array;
        } else {
            return json_decode(file_get_contents("typeCache/" . $type . ".json"), true);
        }
    }
    function search_query($query){
        $url = "http://api.scryfall.com/cards/search?q=" . urlencode("set:eld " . urldecode($_GET['query']));
        $res = json_decode(file_get_contents($url), true);
        foreach($res['data'] as $card){
            $array[] = str_replace("//", "", $card['name']);
        }
        return $array;
    }
?>
