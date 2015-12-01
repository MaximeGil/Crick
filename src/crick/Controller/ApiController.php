<?php

namespace crick\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController {

    public function getPong(Request $request, Application $app) {
        $format = $request->attributes->get('_format');

        switch ($format) {
            case 'html':
                return new Response('<h1>Pong</h1>');
            case 'json':
                return new JsonResponse(array('result' => 'Pong'));
        }
    }

    public function getResult(Request $request, Application $app) {
        $format = $request->attributes->get('_format');

        switch ($format) {
            case 'html':
                return new Response('<h1>Pong</h1>');
            case 'json':
                return new JsonResponse(array('result' => 'Pong'));
        }
    }

    public function helloApi(Request $request, Application $app) {
        $format = $request->attributes->get('_format');

        switch ($format) {
            case 'html':
                return new Response('<h1>Hello API</h1>');
            case 'json':
                return new JsonResponse(array('result' => 'Hello API'));
        }
    }

}
