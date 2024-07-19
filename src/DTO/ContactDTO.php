<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{
    /**
     * @Assert\NotBlank(message="L'adresse email ne doit pas être vide.")
     * @Assert\Email(message="Veuillez entrer une adresse email valide.")
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Le message ne doit pas être vide.")
     */
    private $message;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
