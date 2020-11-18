<?php
namespace App\LayerService\Objects;

use \App\LayerService\Objects\PhavaException;

/**
 * @author Pouya
 */
class Surname
{
    /**
     * Error constants.
     */
    const ERROR_SURNAME_INVALID = 'The provided surname is not valid.';

    /**
     * @var string
     */
    protected $surnameString;

    /**
     * @param string $surnameString
     */
    public function __construct(string $surnameString)
    {
        static::assertSurnameValid($surnameString);

        $this->surnameString = $surnameString;
    }

    /**
     * @return string
     */
    public function getSurnameString(): string
    {
        return $this->surnameString;
    }

    /**
     * @param string $surnameString
     *
     * @return bool
     * @throws PhavaException
     */
    private static function assertSurnameValid(string $surnameString): bool
    {
        if (strlen($surnameString) > 0) {
            return true;
        } else {
            throw new PhavaException(self::ERROR_SURNAME_INVALID);
        }
    }
}

?>