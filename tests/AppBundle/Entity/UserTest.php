<?php


namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class UserTest
 *
 * @package Tests\AppBundle\Entity
 */
class UserTest extends KernelTestCase
{
    /**
     * @param  $username
     * @param  $password
     * @param  $email
     * @param  $roles
     * @return User
     */
    public function getUserEntity($username, $password, $email, $roles): User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setRoles($roles);

        return $user;
    }

    /**
     * @param User $user
     * @param int  $number
     */
    public function assertHasErrors(User $user, int $number = 0)
    {
        $error = self::bootKernel()->getContainer()->get('validator')->validate($user);
        $this->assertCount($number, $error);
    }

    public function testValidUserEntity()
    {
        $this->assertHasErrors(
            $this->getUserEntity(
                'TestUsername',
                '123456',
                'TestUsername@user.com',
                ['ROLE_ADMIN']
            ),
            0
        );
    }

    public function testInvalidEmail()
    {
        $this->assertHasErrors(
            $this->getUserEntity(
                'TestUsername',
                '123456',
                'pasOK',
                ['ROLE_ADMIN']
            ),
            1
        );
    }

    public function testBlankEmail()
    {
        $this->assertHasErrors(
            $this->getUserEntity(
                'TestUsername',
                '123456',
                '',
                ['ROLE_ADMIN']
            ),
            1
        );
    }

    public function testBlankUsername()
    {
        $this->assertHasErrors(
            $this->getUserEntity(
                '',
                '123456',
                'TestUsername@user.com',
                ['ROLE_ADMIN']
            ),
            1
        );
    }

    public function testBlankRole()
    {
        $this->assertHasErrors(
            $this->getUserEntity(
                'TestUsername',
                '123456',
                'TestUsername@user.com',
                []
            ),
            1
        );
    }
}
