<?php
namespace Core\Service;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;
use Core\Entity\User;
use Core\Traits\DoctrineBasicsTrait;

class AuthAdapter implements AdapterInterface
{
    use DoctrineBasicsTrait;

    const AUTH_MSG_SUCCESS = 'Authenticated successfully';
    const AUTH_MSG_FAILURE_CREDENTIAL = 'Invalid credentials';

    /**
     * User email.
     * @var string 
     */
    private $email;
    
    /**
     * Password
     * @var string 
     */
    private $password;
        
    /**
     * Constructor.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * Sets user email.     
     */
    public function setEmail($email) 
    {
        $this->email = $email;        
    }
    
    /**
     * Sets password.     
     */
    public function setPassword($password) 
    {
        $this->password = (string)$password;        
    }
    
    /**
     * Performs an authentication attempt.
     */
    public function authenticate()
    {
        // Check the database if there is a user with such email.
        $user = $this->getRepository(User::class)->findOneByEmail($this->email);
        
        // If there is no such user, return 'Identity Not Found' status.
        if ($user == null) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null, [self::AUTH_MSG_FAILURE_CREDENTIAL]);
        }
        
        // Now we need to calculate hash based on user-entered password and compare
        // it with the password hash stored in database.
        $bcrypt = new Bcrypt();
        if ($bcrypt->verify($this->password, $user->getPassword())) {
            return new Result(Result::SUCCESS, $this->email, [self::AUTH_MSG_SUCCESS]);
        }
        
        // If password check didn't pass return 'Invalid Credential' failure status.
        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, [self::AUTH_MSG_FAILURE_CREDENTIAL]);
    }
}
