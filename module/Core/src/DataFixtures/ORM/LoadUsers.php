<?php
namespace Core\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Zend\Crypt\Password\Bcrypt;
use Core\Entity\User;

class LoadUsers extends AbstractFixture implements DependentFixtureInterface
{

    /**
     * @var array The user that will be inserted in the database table
     */
    protected $users = [
        [
            'email' => 'admin@filini.by',
            'status' => USER::STATUS_ACTIVE,
            'firstName' => 'Admin',
            'lastName' => '',
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(User::BCRYPT_PASSWORD_COST);

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

    /**
     * Fixture classes fixture is dependent on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [];
    }
}
