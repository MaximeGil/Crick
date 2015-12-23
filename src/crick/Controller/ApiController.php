<?php

namespace crick\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Ramsey\Uuid\Uuid;

class ApiController {

    public function getPongAction(Request $request, Application $app) {
        $format = $request->attributes->get('_format');
        $user = $app['security']->getToken()->getUser();
        $username = is_object($user) ? $user->getUsername() : $user;

        switch ($format) {
            case 'html':
                return new Response(sprintf('<h1>pong: %s</h1>', $username));
            case 'json':
                return new JsonResponse([
                    'username' => $username,
                    'message' => 'pong',
                ]);
        }
    }

    public function postFrame(Request $request, Application $app) {
        $format = $request->headers->get('Content-Type');

        if ($format == "application/json") {
            // on récupère les données 
            $data = json_decode($request->getContent());

            // on récupère l'apikey de l'utilisateur et son nom
            $token = $app['security']->getToken()->getUser()->getApiKey();
            $username = $app['security']->getToken()->getUser()->getUsername();

            // on récupère l'uuid de l'utilisateur en cours
            $result = $app['db']
                    ->getModel('db\Db\PublicSchema\UsersModel')
                    ->findUuidByName($username);
            $uuid = $result->get(0)->getUuid();

            foreach ($data as $key => $elements) {

                // on récupère le nom du projet
                $nameProject = $elements->project;

                $result = $app['db']
                        ->getModel('db\Db\PublicSchema\ProjectModel')
                        ->findProjectExist($uuid, $nameProject);
                var_dump($elements->project);
                if ($result->count() == 0) {
                    // on ajoute le projet
                    $app['db']->getModel('db\Db\PublicSchema\ProjectModel')
                            ->createAndSave([
                                'uuid' => Uuid::uuid1()->toString(),
                                'name' => $nameProject,
                                'uuiduser' => $uuid,
                    ]);

                    // on récupère l'id du projet

                    $result = $app['db']
                            ->getModel('db\Db\PublicSchema\ProjectModel')
                            ->findWhere('name = $*', [$nameProject]);
                    $idProject = $result->get(0)->getUuid();

                    // on ajoute les frames
                    $app['db']->getModel('db\Db\PublicSchema\FrameModel')
                            ->createAndSave([
                                'idframe' => $elements->id,
                                'startframe' => $elements->start,
                                'stopframe' => $elements->stop,
                                'uuidproject' => $idProject,
                    ]);

                    foreach ($elements->tags as $tag) {
                        $app['db']->getModel('db\Db\PublicSchema\TagModel')
                                ->createAndSave([
                                    'uuid' => Uuid::uuid1()->toString(),
                                    'idframe' => $elements->id,
                                    'tag' => $tag,
                        ]);
                    }
                } else {
                    
                    // on récupère l'id du projet

                    $result = $app['db']
                            ->getModel('db\Db\PublicSchema\ProjectModel')
                            ->findWhere('name = $*', [$nameProject]);
                    $idProject = $result->get(0)->getUuid();
                    $test = "on passe";
                    var_dump($test);
                    // on ajoute les frames
                    $app['db']->getModel('db\Db\PublicSchema\FrameModel')
                            ->createAndSave([
                                'idframe' => $elements->id,
                                'startframe' => $elements->start,
                                'stopframe' => $elements->stop,
                                'uuidproject' => $idProject,
                    ]);
                     foreach ($elements->tags as $tag) {
                        $app['db']->getModel('db\Db\PublicSchema\TagModel')
                                ->createAndSave([
                                    'uuid' => Uuid::uuid1()->toString(),
                                    'idframe' => $elements->id,
                                    'tag' => $tag,
                        ]);
                }}
        } 
                //var_dump($data);
                return new Response('Success', 201);

        }
    }

    public function getProjects(Request $request, Application $app) {
        $format = $request->attributes->get('_format');
        $user = $app['security']->getToken()->getUser();
        $username = is_object($user) ? $user->getUsername() : $user;

        // on récupère l'uuid de l'utilisateur
        $result = $app['db']
                ->getModel('db\Db\PublicSchema\UsersModel')
                ->findUuidByName($username);

        $uuid = $result->get(0)->getUuid();

        // on récupère les projets de l'utilisateur
        $result = $app['db']
                ->getModel('db\Db\PublicSchema\ProjectModel')
                ->findWhere('uuiduser = $*', [$uuid]);

        if ($format == 'json') {
            return json_encode($result);
        }
    }

}
