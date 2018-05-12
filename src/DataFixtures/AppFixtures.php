<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Blog;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    private $userRepository;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $encoder)
    {
        $this->encoder        = $encoder;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
    }

    private function loadBlogPosts(ObjectManager $manager): void
    {
        $blogPostData = $this->getBlogPostData();
        foreach ($blogPostData as $row) {
            //create a blog post
            $user = new Blog();
            $user->setTitle($row['title']);
            $user->setShortContent($row['short_content']);
            $user->setContent($row['content']);
            $user->setAuthor($row['author']);
            $user->setIsDraft(0);
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager): void
    {
        $usersData = $this->getUserData();
        foreach ($usersData as $row) {
            //create a user
            $user = new User();
            $user->setUsername($row['username']);
            $user->setPassword($this->encoder->encodePassword($user, $row['password']));
            $user->setEmail($row['email']);
            $user->setRoles($row['roles']);
            $user->setFirstName($row['firstName']);
            $user->setLastName($row['lastName']);
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            [
                'username'  => 'admin',
                'password'  => 'password',
                'email'     => 'admin@admin.com',
                'firstName' => 'Admin',
                'lastName'  => 'Admin',
                'roles'     => [
                    'ROLE_ADMIN'
                ]
            ],
            [
                'username'  => 'testuser',
                'password'  => 'password',
                'email'     => 'user@user.com',
                'firstName' => 'User',
                'lastName'  => 'User',
                'roles'     => [
                    'ROLE_USER'
                ],
            ],
        ];
    }

    private function getBlogPostData(): array
    {
        $author = $this->userRepository->findOneBy([]);
        return [
            [
                'title'         => 'My first blog post title',
                'short_content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'content'       => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.',
                'author'        => $author
            ],
            [
                'title'         => 'My second blog post title',
                'short_content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
                'content'       => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.',
                'author'        => $author
            ],
        ];
    }
}
