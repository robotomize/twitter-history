<?php
declare(strict_types = 1);

namespace FoulTweets;

use Carbon\Carbon;
use IllegalArgumentException;

/**
 * Class UserValidator
 * @package FoulTweets
 * @author robotomize@gmail.com
 */
class UserValidator implements InterfaceValidator
{
    /**
     * @param UserModel $user
     * @throws IllegalArgumentException
     * @throws ValidationException
     */
    public static function validate(InterfaceModel $user)
    {
        if ($user === null) {
            throw new IllegalArgumentException('Argument cannot be null');
        }

        if ($user->getName() === null || $user->getName() === '') {
            throw new IllegalArgumentException('The user name cannot be empty');
        }

        if ($user->getCount() <= 0) {
            throw new ValidationException('The number can not be 0');
        }

        if ($user->getSince() !== null) {
            if ($user->getSince() > Carbon::now()->format('Y-m-d')) {
                throw new IllegalArgumentException('The wrong starting date');
            }

            if ($user->getUntil() > Carbon::now()->format('Y-m-d')) {
                throw new IllegalArgumentException('The wrong ending date');
            }
        }
    }
}