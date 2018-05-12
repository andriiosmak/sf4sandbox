<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(BlogRepository $repository)
    {
        return $this->render('blog/index.html.twig', [
            'posts' => $repository->getActive()
        ]);
    }
}
