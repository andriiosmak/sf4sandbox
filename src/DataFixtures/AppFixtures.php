<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserProfile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
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
}
