<?php
namespace Core\Repository;

/**
 * UserRepository
 */
class UserRepository extends AbstractRepository
{
	const TABLE_ALIAS = 'users';

	/**
     * Find user by email
     *
     * @param string $email
     * @return User | null
     */
    public function findOneBySlug($email)
    {
        return $this->findOneBy(array(
            'email' => $email,
        ));
    }

    /**
     * Retrieve users
     *
     * @return \Doctrine\ORM\Query
     */
    public function findUsers()
    {
        return $this->getQueryBuilder()->getQuery();
    }
}
