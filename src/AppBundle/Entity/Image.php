<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 */
class Image
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $unique_id;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the image.")
     * @Assert\File(mimeTypes={ "image/*" }, mimeTypesMessage="File format is not allowed. Supported formats png, jpg, gif, jpeg, etc....")
     */
    protected $file;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, enter the email.")
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    protected $email;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set uniqueId
     *
     * @param string $uniqueId
     *
     * @return Image
     */
    public function setUniqueId($uniqueId)
    {
        $this->unique_id = $uniqueId;

        return $this;
    }

    /**
     * Get uniqueId
     *
     * @return string
     */
    public function getUniqueId()
    {
        return $this->unique_id;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Image
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Image
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
