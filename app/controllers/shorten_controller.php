<?php

class ShortenController extends AppController
{
    public function index()
    {
        try {
            if ($hash_id = Param::get("v")) {
                $link = Url::getLinkByHashId($hash_id);
                $this->redirect($link);
            }
        } catch (RecordNotExistException $e) {
            $this->setFlash("Url not found.", "error");
        }
    }

    public function process()
    {
        try {
            if (!Param::isMethodPost()) {
                throw new InvalidHTTPRequestException();
            }

            $url = Param::post('url');
            if (!$url) {
                throw new InvalidArgumentException();
            }

            $url_model = new Url($url);
            $url = $url_model->shorten();

        } catch (InvalidHTTPRequestException $e) {
            $this->setFlash("Invalid input", "error");
            return;
        } catch (InvalidArgumentException $e) {
            $this->setFlash("Invalid input", "error");
            return;
        }

        $this->set(get_defined_vars());
    }
}
