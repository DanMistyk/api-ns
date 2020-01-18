<?php
namespace AppBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use AppBundle\Entity\User;
use Psr\Log\LoggerInterface;

class UserEvent implements EventSubscriber 
{
    private $loggerInterface;

    public function __construct(LoggerInterface $loggerInterface)
    {
        $this->loggerInterface = $loggerInterface;
    }

    public function getSubscribedEvents() {
        return array('preUpdate');
    }


    public function preUpdate(LifecycleEventArgs $args) 
    {
        $entity = $args->getEntity();
        $changeset = $args->getEntityManager()->getUnitOfWork()->getEntityChangeSet($entity);
        if ($entity instanceof User) {
            if (array_key_exists("firstname", $changeset) || array_key_exists("lastname", $changeset)) {
                $this->loggerInterface->notice(json_encode($changeset));
            }
        }
    }

}