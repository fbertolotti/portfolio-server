<?php

namespace ProjectBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ProjectBundle\Entity\Technology;

class LoadTechnologies implements FixtureInterface, ContainerAwareInterface
{
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        foreach ([
            'PHP',
            'Symfony2',
            'Symfony3',
            'HTML',
            'CSS',
            'JavaScript',
            'less',
            'Sass',
            'TypeScript',
        ] as $name) {
            if (!$em->getRepository('ProjectBundle:Technology')->findByName($name)) {
                $tech = new Technology();
                $tech->setName($name);
                $tech->setEnabled(true);
                $manager->persist($tech);
            }
        }

        $manager->flush();
    }
}
