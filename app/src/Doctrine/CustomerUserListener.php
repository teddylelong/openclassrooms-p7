<?php

namespace App\Doctrine;

use App\Entity\CustomerUser;
use Symfony\Component\Security\Core\Security;

class CustomerUserListener
{
    private $security;

    /**
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param CustomerUser $customerUser
     * @return void
     */
    public function prePersist(CustomerUser $customerUser): void
    {
        // If Customer has already set, return
        if ($customerUser->getCustomer()) {
            return;
        }

        if ($this->security->getUser()) {
            $customerUser->setCustomer($this->security->getUser());
        }
    }
}