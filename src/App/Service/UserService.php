<?php
namespace App\Service;

use Doctrine\ORM\EntityManager;
use App\Entity\User;

class UserService
{
    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     */
    public function sessionize(User $user)
    {
        $this->em->detach($user);
        $_SESSION['user'] = $user;
    }

    /**
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public function getUsingEmailAndPassword($email, $password)
    {
        $user = $this->em->getRepository('App\Entity\User')
            ->findOneBy(array(
                'email' => $email,
            )
        );

        if (empty($user) === false
            && password_verify($password, $user->getPassword())
        ) {
            return $user;
        }

        return null;
    }

    /**
     * @return User
     */
    public function getFromSession()
    {
        return $this->em->merge($_SESSION['user']);
    }

}
