<?php

namespace App\Security\Voter;

use App\Entity\Quack;
use App\Entity\Duck;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class QuackVoter extends Voter
{
    const EDIT = 'EDIT';
    const  DELETE = "DELETE";
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['EDIT', 'DELETE'])
            && $subject instanceof \App\Entity\Quack;
    }

    protected function voteOnAttribute(string $attribute, $quack, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

       if (null == $quack->getAuthor()){
           return false;
       }
        switch ($attribute) {
            case self::EDIT:
                return $quack->getAuthor()->getId() == $user->getId();
                break;
            case self::DELETE:
                return $quack->getAuthor()->getId() == $user->getId();
                break;
        }

        return false;
    }
private function canView(Post $post, User $user): bool
{
    // if they can edit, they can view
    if ($this->canEdit($post, $user)) {
        return true;
    }

    // the Post object could have, for example, a method `isPrivate()`
    return !$post->isPrivate();
}
}
