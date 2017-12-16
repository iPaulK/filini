<?php
namespace Core\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Crypt\Password\Bcrypt;
use Core\Entity\User\Admin;
use Core\Entity\Role;
use Core\Entity\UserAddress;

class LoadUsers extends AbstractFixture implements OrderedFixtureInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var array The user that will be inserted in the database table
     */
    protected $users = [
        [
            'email' => 'admin@filini.by',
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $zfcUserService = $this->getServiceLocator()->get('zfcuser_user_service');
        $bcrypt = new Bcrypt();
        $bcrypt->setCost($zfcUserService->getOptions()->getPasswordCost());

        foreach ($this->users as $data) {
            $user = $this->findOrCreateAdmin($data['email'], $manager);
            /** Check if the object is managed (so already exists in the database) **/
            if (!$manager->contains($user)) {
                $user
                    ->setEmail($data['email'])
                    ->setPassword($bcrypt->create('password'));
                $manager->persist($user);
            }
            $this->addReference($data['email'] . '-user', $user);
        }

        $manager->flush();
    }

    /**
     * Helper method to return an already existing user from the database, else create and return a new one
     *
     * @param string $email
     * @param ObjectManager $manager
     *
     * @return Core\Entity\User
     */
    protected function findOrCreateAdmin($email, ObjectManager $manager)
    {
        return $manager->getRepository('Core\Entity\User')->findOneBy(['email' => $email]) ?: new User();
    }

    public function getOrder()
    {
        return 1;
    }
}
