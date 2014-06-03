<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Default controller.
 *
 */
class DefaultController extends Controller
{
    /**
     * Basic redirect of empty route.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY') ){
            return $this->redirect($this->generateUrl('UMRA_Person_Profile'));
        } else {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
    }
}
