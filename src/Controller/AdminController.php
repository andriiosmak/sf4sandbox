<?php

namespace App\Controller;

use App\Entity\Blog;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    /**
     *Persist blog entry
     *
     * @param \App\Entity\Blog $blog
     *
     * @return void
     */
    public function persistBlogEntity(Blog $blog): void
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $blog->setAuthor($user);
        parent::persistEntity($blog);
    }
}
