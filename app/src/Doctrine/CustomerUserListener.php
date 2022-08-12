<?php

namespace App\Doctrine;

use App\Entity\CustomerUser;
use Symfony\Component\Security\Core\Security;

/**
 * This class allows to perform some operations on data sent before recording or updating an item
 */
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
     * Before recording, set the Customer to current authenticated user
     *
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

    /**
     * Before updating, set the updated_at row to current datetime
     *
     * @param CustomerUser $customerUser
     * @return void
     */
    public function preUpdate(CustomerUser $customerUser): void
    {
        $customerUser->setUpdatedAt(new \DateTimeImmutable('now'));
    }
}
