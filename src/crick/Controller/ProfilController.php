<?php
namespace crick\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ProfilController
 *
 * @author maxime
 */
class ProfilController {
 
    public function getProfil(Application $app)
    {
        $token = $app['security.token_storage']->getToken()->getUser();
        $data = array(
            'username' => $token->getUsername(),
            'apikey' => $token->getApiKey(),
        );
        
        return $app['twig']->render('profil.twig.html', $data);
        
    }
}
