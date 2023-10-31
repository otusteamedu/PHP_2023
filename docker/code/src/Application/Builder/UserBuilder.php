<?php


namespace IilyukDmitryi\App\Application\Builder;

use IilyukDmitryi\App\Application\Dto\UserRequestDto;
use IilyukDmitryi\App\Domain\Entity\User;
use IilyukDmitryi\App\Domain\Exception\UserException;
use IilyukDmitryi\App\Domain\Model\UserModel;

class UserBuilder
{
    /**
     * @throws UserException
     */
    public static function build(UserRequestDto $userRequestDto): User
    {
        $name = trim($userRequestDto->getName());
        $id = $userRequestDto->getId();
       
        if($name === ''){
            throw new UserException("Введите Имя")  ;
        }
        
        $user = new User();
        $user->setId($id)->setName($name);
        $userModel = new UserModel();
        $userFromRepository = $userModel->getOrCreateUser($user);
        
        return $userFromRepository;
    }
}