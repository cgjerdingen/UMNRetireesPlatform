<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Default controller.
 *
 */
class DashboardController extends Controller
{
    /**
     * Basic redirect of empty route.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('UMRAMemberBundle:Dashboard:index.html.twig', []);
    }
}
