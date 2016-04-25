<?php

namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 * @Entity
 * @Table(name="users")
 */
class User
{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $email;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $password;
    
    /**
     * @return int
     */
    function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    function getPassword()
    {
        return $this->password;
    }
}