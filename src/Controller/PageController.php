<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function index()
    {
        return $this->render('page/index.html.twig');
    }

     /**
     * @Route("/auth", name="auth")
     *  @IsGranted("ROLE_USER")
     * 
     */
    public function auth()
    {
        return $this->render('page/index.html.twig');
    }

    
}
