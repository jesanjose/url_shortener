<?php
class Url extends AppModel
{
    public $url;

    const SHUFFLE_STRING = "abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

    function __construct($url)
    {
        $this->url = $url;
        $this->validate();
    }

    public function validate()
    {
        $filtered_url = filter_var($this->url, FILTER_VALIDATE_URL);
        if ($filtered_url === false) {
            throw new InvalidArgumentException();
        }
    }

    public function shorten()
    {
        // remove http: or https:
        $tmp_url = preg_replace("/(http|https)\:/", "", $this->url);
        $tmp_url = explode("/", $tmp_url);
        $tmp_url = array_values(array_filter($tmp_url));
        $tmp_url = explode(".", $tmp_url[0]);

        $append_url = $tmp_url[1];
        if (count($tmp_url) <= 2) {
            $append_url = $tmp_url[0];
        }

        $shuffled_string = substr(str_shuffle(self::SHUFFLE_STRING), 0, 5);
        $shortened_url = $append_url."-".$shuffled_string;

        $db = DB::conn();
        $db->insert("url", array("hash_id" => $shortened_url, "link" => $this->url));

        return APP_URL."?v=".$shortened_url;
    }

    public static function getLinkByHashId($hash_id)
    {
        $db = DB::conn();
        $res = $db->value("SELECT link FROM url WHERE hash_id = ?", array($hash_id));

        if (!$res) {
            throw new RecordNotExistException();
        }

        return $res;
    }
}