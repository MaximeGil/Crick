<?php

namespace crick\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use crick\Form\FormProject;
use Ramsey\Uuid\Uuid;

class ProjectController
{
    public function getOrCreateProjects(Request $request, Application $app)
    {
        $username = $app['security']->getToken()->getUser()->getUsername();

        // on récupère l'uuid de l'utilisateur en cours
        $result = $app['db']
                ->getModel('db\Db\PublicSchema\UsersModel')
                ->findUuidByName($username);

        $uuid = $result->get(0)->getUuid();

        $data = array('nameproject' => 'project name');

        $newForm = new FormProject();
        $form = $newForm->createForm($app);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $app['db']->getModel('db\Db\PublicSchema\ProjectModel')
                    ->createAndSave([
                        'uuid' => Uuid::uuid1()->toString(),
                        'name' => $data['name'],
                        'uuiduser' => $uuid,
            ]);

            return $app['twig']->render('hello.twig.html');
        }

        // on récupère les projets de l'utilisateur
        $result = $app['db']
                ->getModel('db\Db\PublicSchema\ProjectModel')
                ->getProjects($uuid);

        $result2 = $app['db']
                ->getModel('db\Db\PublicSchema\ProjectModel')
                ->getProjectsInactive($uuid);

        return $app['twig']->render('projects.twig.html', array('projects' => $result, 'projectsinactive' => $result2, 'form' => $form->createView(), 'count' => count($result), 'colors' => array('blue' => '#7E70FA', 'red' => '#FA7080')));
    }

    public function getProjectById(Request $request, Application $app, $id)
    {
        $result = $app['db']
                ->getModel('db\Db\PublicSchema\FrameModel')
                ->getFrameAndTags($id);

        return $app['twig']->render('frames.twig.html', array('frames' => $result));
    }
}
