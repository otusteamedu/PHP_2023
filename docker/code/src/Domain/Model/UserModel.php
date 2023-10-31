<?php


namespace IilyukDmitryi\App\Domain\Model;

use DI\DependencyException;
use DI\NotFoundException;
use IilyukDmitryi\App\Di;
use IilyukDmitryi\App\Domain\Entity\User;
use IilyukDmitryi\App\Domain\Repository\FactoryRepositoryInterface;
use IilyukDmitryi\App\Domain\Repository\UserRepositoryInterface;

class UserModel
{
    private static ?UserRepositoryInterface $userRepository = null;
    
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct()
    {
        self::makeRepository();
    }
    
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private static function makeRepository(): void
    {
        if(is_null(self::$userRepository)){
            
            $c = Di::getContainer();
            $factoryRepository = $c->get(FactoryRepositoryInterface::class);
            
            /** @var $UserRepository  UserRepositoryInterface */
            self::$userRepository = $factoryRepository->getUserRepository();
        }
    }
    
    public function getOrCreateUser(User $user): ?User
    {
        $userId = $user->getId();
        if($userId === 0 || self::$userRepository->getById($userId) === null){
            $userId =  self::$userRepository->add($user);
        }
        return self::$userRepository->getById($userId);
    }
    
    public function getUserById(int $userId): ?User
    {
        return self::$userRepository->getById($userId);
    }
}