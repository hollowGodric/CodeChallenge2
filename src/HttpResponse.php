<?php

namespace App;


class HttpResponse
{
    private $content;
    private $code;
    protected $contentType = '';

    /**
     * HttpResponse constructor.
     * @param $content
     * @param $code
     */
    public function __construct($content, $code = 200)
    {
        $this->content = $content;
        $this->code = $code;
    }

    public function render()
    {
        \http_response_code($this->code);
        if (isset($this->contentType)) {
            header("Content-type: $this->contentType");
        }

        print $this->content;
    }

    public function getStatus()
    {
        return $this->code;
    }
}