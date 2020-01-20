<?php

namespace Scitap\BadgeBundle\Manager;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Scitap\BadgeBundle\Entity\BadgeUnlock;
use Scitap\BadgeBundle\Event\BadgeUnlockEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


class BadgeManager
{
    /**
     * @var ObjectManager
     */
    private $em;

    private $dispatcher;

    public function __construct(ObjectManager $em,EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param User $user
     * @param string $action
     * @param int $action_count
     */
    public function checkAndUnlock(User $user, string $action, int $action_count): void
    {
        //vérifier si on a un badge qui correspond à action et action_count
        $badges = $this->em->getRepository('BadgeBundle:Badge')->findBy([
            'actionName' => $action,
            'actionCount' => $action_count
        ]);
        if (!empty($badges)) {
            $badge = $badges[0];
            //vérfier si l'utilisateur a déja ce badge
            $badgeUnlockedForCurrentUser = $this->em->getRepository('BadgeBundle:BadgeUnlock')->findBy([
                'user' => $user,
                'badge' => $badge
            ]);
            // débloquer le badge pour l'utilisateur en question s'il en a pas
            if (empty($badgeUnlockedForCurrentUser)) {
                $badgeUnlock = new BadgeUnlock();
                $badgeUnlock->setUser($user);
                $badgeUnlock->setBadge($badge);
                $this->em->persist($badgeUnlock);
                $this->em->flush();

                //Emettre un évenement pour informer l'application  du déblocage du badge
                $this->dispatcher->dispatch(BadgeUnlockEvent::NAME,new BadgeUnlockEvent($badgeUnlock));
            }
        }


    }

    /**
     * @param User $user
     * @return array
     */
    public function getBadgesForUser(User $user): array
    {
        return $this->em->getRepository('BadgeBundle:Badge')->getBadgesForUser($user);
    }
}