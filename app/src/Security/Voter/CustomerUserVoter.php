<?php

namespace App\Security\Voter;

use App\Entity\CustomerUser;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CustomerUserVoter extends Voter
{
    public const CREATE = 'USER_CREATE';
    public const READ = 'USER_READ';
    public const UPDATE = 'USER_UPDATE';
    public const DELETE = 'USER_DELETE';

    private $security;

    /**
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param string $attribute
     * @param $subject
     * @return bool
     */
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::CREATE, self::READ, self::UPDATE, self::DELETE])
            && $subject instanceof \App\Entity\CustomerUser;
    }

    /**
     * @param string $attribute
     * @param $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        // If the user is admin, grant access
        if ($this->security->isGranted('ROLE_ADMIN', $user)) {
            return true;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::CREATE:
                return $this->canCreate($user, $subject);
            case self::READ:
                return $this->canRead($user, $subject);
            case self::UPDATE:
                return $this->canUpdate($user, $subject);
            case self::DELETE:
                return $this->canDelete($user, $subject);
        }

        throw new \Exception(sprintf('Unhandled attribute "%s"', $attribute));
    }

    /**
     * @param UserInterface $user
     * @param CustomerUser $customerUser
     * @return bool
     */
    private function canCreate(UserInterface $user, CustomerUser $customerUser): bool
    {
        if ($this->security->isGranted('ROLE_USER', $user)) {
            return true;
        }
        return false;
    }

    /**
     * @param UserInterface $user
     * @param CustomerUser $customerUser
     * @return bool
     */
    private function canRead(UserInterface $user, CustomerUser $customerUser): bool
    {
        if ($customerUser->getCustomer() === $user) {
            return true;
        }
        return false;
    }

    /**
     * @param UserInterface $user
     * @param CustomerUser $customerUser
     * @return bool
     */
    private function canUpdate(UserInterface $user, CustomerUser $customerUser): bool
    {
        if ($customerUser->getCustomer() === $user) {
            return true;
        }
        return false;
    }

    /**
     * @param UserInterface $user
     * @param CustomerUser $customerUser
     * @return bool
     */
    private function canDelete(UserInterface $user, CustomerUser $customerUser): bool
    {
        if ($customerUser->getCustomer() === $user) {
            return true;
        }
        return false;
    }
}
