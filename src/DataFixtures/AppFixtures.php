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

            //create a profile
            $profile = new UserProfile();
            $profile->setFirstName($row['profile']['first_name']);
            $profile->setLastName($row['profile']['last_name']);

            //assign created profile
            $user->setProfile($profile);
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            [
                'username' => 'admin',
                'password' => 'password',
                'email'    => 'admin@admin.com',
                'roles'    => [
                    'ROLE_ADMIN'
                ],
                'profile'  => [
                    'first_name' => 'Admin',
                    'last_name'  => 'Admin',
                ]
            ],
            [
                'username' => 'testuser',
                'password' => 'password',
                'email'    => 'user@user.com',
                'roles'    => [
                    'ROLE_USER'
                ],
                'profile'  => [
                    'first_name' => 'User',
                    'last_name'  => 'User',
                ]
            ],
        ];
    }
}
