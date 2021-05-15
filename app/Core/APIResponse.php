<?php

namespace App\Core;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class APIResponse extends JsonResponse
{
    /**
     * APIResponse constructor.
     * @param Request $request
     * @param int $httpStatus
     * @param array $headers
     * @param int $jsonOptions
     * @param array $content
     * @param mixed|null $data
     */
    public function __construct(
        Request $request,
        int $httpStatus = Response::HTTP_OK,
        array $headers = [],
        int $jsonOptions = 0,
        array $content = [],
        $data = null
    )
    {
        parent::__construct($content, $httpStatus, $headers, $jsonOptions);
    }
}
