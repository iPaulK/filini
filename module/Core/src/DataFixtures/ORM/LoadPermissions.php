<?php
namespace Core\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Core\Entity\Permission;

class LoadPermissions extends AbstractFixture
{

    /**
     * @var array of permissions that will be inserted in the database table
     */
    protected $permissions = [
        [
            'name' => 'user.manage',
            'description' => 'Manage users',
        ],
        [
            'name' => 'role.manage',
            'description' => 'Manage roles',
        ],
        [
            'name' => 'permission.manage',
            'description' => 'Manage permissions',
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->permissions as $data) {
            $permission = $this->findOrCreatePermission($data['name'], $manager);
            /** Check if the object is managed (so already exists in the database) **/
            if (!$manager->contains($permission)) {
                $permission
                    ->setName($data['name'])
                    ->setDescription($data['description']);
                $manager->persist($permission);
            }
            $this->addReference($data['name'] . '-permission', $permission);
        }

        $manager->flush();
    }

    /**
     * Helper method to return an already existing permission from the database, else create and return a new one
     *
     * @param string $name
     * @param ObjectManager $manager
     *
     * @return Core\Entity\Permission
     */
    protected function findOrCreatePermission($name, ObjectManager $manager)
    {
        return $manager->getRepository('Core\Entity\Permission')->findOneBy(['name' => $name]) ?: new Permission();
    }
}
