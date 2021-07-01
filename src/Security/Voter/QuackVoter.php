<?php

namespace App\Security\Voter;

use App\Entity\Quack;
use App\Entity\Duck;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class QuackVoter extends Voter
{
    const EDIT = 'CAN_EDIT';
    const DELETE = 'CAN_DELETE';
    protected function supports(string $attribute, $subject): bool
    {
        if(self::EDIT == $attribute || self::DELETE == $attribute){
            return true;
        }

    return false;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        //Check si le sujet est une instance de Quack.
        //Puis check si l'auteur du sujet est l'utilisateur connecté($token->getUser())
        if ($subject instanceof Quack){
            if ($subject->getAuthor() === $token->getUser()){
                return true;
            }
            if ($subject->getParent()){
                $parentVote = $this->voteOnAttribute($attribute,$subject->getParent(),$token);
                if ($parentVote){
                    return true;
                }
            }
        }

        return false;
    }
}
