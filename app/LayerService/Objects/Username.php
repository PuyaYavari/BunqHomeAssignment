<?php
namespace App\LayerService\Objects;

use \App\LayerService\Objects\PhavaException;

/**
 * @author Pouya
 */
class Username
{
    /**
     * Error constants.
     */
    const ERROR_USERNAME_INVALID = 'The provided username is not valid.';

    /**
     * @var string
     */
    protected $usernameString;

    /**
     * @param string $usernameString
     */
    public function __construct(string $usernameString)
    {
        static::assertUsernameValid($usernameString);

        $this->usernameString = $usernameString;
    }

    /**
     * @return string
     */
    public function getUsernameString(): string
    {
        return $this->usernameString;
    }

    /**
     * @param string $usernameString
     *
     * @return bool
     * @throws PhavaException
     */
    private static function assertUsernameValid(string $usernameString): bool
    {
        if (strlen($usernameString) > 0) {
            return true;
        } else {
            throw new PhavaException(self::ERROR_USERNAME_INVALID);
        }
    }
}

?>