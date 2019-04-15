<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min = 2, minMessage="Vous devez rentrer minimum 2 caractères")
     */
    private $name;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;


    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private $subject;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min = 10, minMessage="Vous devez rentrer minimum 10 caractères")
     */
    private $message;


    /**
     * @return null|string
     */
    public function getname()
    {
        return $this->name;
    }

    /**
     * @param null|string $firstname
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return null|string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param null|string $phone
     * @return Contact
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}