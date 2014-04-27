<?php

namespace Acme\UserBundle\Validator;

use Symfony\Component\Security\Core\User\UserInterface;
use Acme\UserBundle\Entity\UserManagerInterface;
use Symfony\Component\Validator\ObjectInitializerInterface;

/**
 * Automatically updates the canonical fields before validation.
 *
 */
class Initializer implements ObjectInitializerInterface
{
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function initialize($object)
    {
        if ($object instanceof UserInterface) {
            $this->userManager->updateCanonicalFields($object);
        }
    }
}
