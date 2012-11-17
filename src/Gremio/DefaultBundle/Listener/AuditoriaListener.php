<?php

namespace Gremio\DefaultBundle\Listener;
 
use Doctrine\ORM\Event\LifecycleEventArgs;
 
class AuditoriaListener {
 
    
 
    public function preUpdate(LifecycleEventArgs $args) 
            {
            $entity = $args->getEntity();
            $entityManager = $args->getEntityManager();
                if ($entity instanceof \Gremio\AbmBundle\Entity\Socio) 
                {
                    $entity->setLastModifDate(new \DateTime('2012-05-05'));
                    
                    
                }
            }
    
 
}
?>
