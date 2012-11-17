<?php

namespace Gremio\SecurityBundle\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Gremio\SecurityBundle\Entity\User;
use Gremio\SecurityBundle\Entity\Role;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Doctrine\Common\Persistence\ObjectManager;
 
class FixtureLoader extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // create the ROLE_ADMIN role
        $role = new Role();
        //$role->setName('ROLE_DATAENTRY');
        $role->setName('ROLE_DATAENTRY');
        $role2 = new Role();
        $role2->setName('ROLE_OTRO');
        
        $manager->persist($role);
        $manager->persist($role2);
 
        // create a user
        $user = new User();
        $user->setFirstName('Ezequiel');
        $user->setLastName('Zacca');
        $user->setEmail('ezequiel.zacca@netsecom.com.ar');
        $user->setUsername('EZacca');
        $user->setSalt(md5(time()));
 
        // encode and set the password for the user,
        // these settings match our config
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword('admin', $user->getSalt());
        $user->setPassword($password);
 
        $user->getUserRoles()->add($role);
        
        $user2 = new User();
        $user2->setFirstName('Gustavo');
        $user2->setLastName('Manzur');
        $user2->setEmail('gustavo.manzur@netsecom.com.ar');
        $user2->setUsername('GManzur');
        $user2->setSalt(md5(time()));
 
        // encode and set the password for the user,
        // these settings match our config
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword('admin', $user2->getSalt());
        $user2->setPassword($password);
 
        $user2->getUserRoles()->add($role2);
 
        $manager->persist($user);
        $manager->persist($user2);
        
        $manager->flush();
 
        // ...
 
    }
    public function getOrder()
    {
        return 3; // number in which order to load fixtures
    }
}
?>
