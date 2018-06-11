<?php

namespace App;


class JsonResponse extends HttpResponse
{
    /**
     * JsonResponse constructor.
     * @param     $serializable
     * @param int $code
     */
    public function __construct($serializable, $code = 200)
    {
        $this->contentType = 'application/json';
        parent::__construct(\GuzzleHttp\json_encode($serializable), $code);
    }


}