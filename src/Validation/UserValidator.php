<?php

declare(strict_types=1);

namespace Twent\Hw13\Validation;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Tree\Message\Messages;
use CuyZ\Valinor\MapperBuilder;
use Twent\Hw13\Validation\DTO\InsertUserDto;
use Twent\Hw13\Validation\DTO\UserDto;

final class UserValidator
{
    public static function validate(
        array $data,
        ValidationType $type = ValidationType::Default
    ): UserDto|InsertUserDto {
        $reference = $type === ValidationType::Default
            ? UserDto::class
            : InsertUserDto::class;

        try {
            $userDto = (new MapperBuilder())
                ->mapper()
                ->map($reference, $data);
        } catch (MappingError $error) {
            $messages = Messages::flattenFromNode($error->node());

            foreach ($messages->errors() as $message) {
                $message = $message->withBody("Field {node_path} {original_message}");
                throw new \InvalidArgumentException((string) $message);
            }
        }

        return $userDto;
    }
}
