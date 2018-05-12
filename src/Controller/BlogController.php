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

    /**
     * @Route("/blog/{postId}", name="blog_show", requirements={"postId"="\d+"})
     */
    public function show(BlogRepository $repository, int $postId)
    {
        $post = $repository->find($postId);

        if (null === $post) {
            throw $this->createNotFoundException('The blog post does not exist');
        }

        return $this->render('blog/show.html.twig', [
            'post' => $post
        ]);
    }
}
