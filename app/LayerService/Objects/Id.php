<?php
namespace App\LayerService\Objects;

/**
 * @author Pouya
 */
class Id
{
    /**
     * Error constants.
     */
    const ERROR_ID_INVALID = 'The provided id is not valid.';

    /**
     * @var int
     */
    protected $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        static::assertIdValid($value);

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getIdInt(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     *
     * @return bool
     * @throws PhavaException
     */
    private static function assertIdValid(int $value): bool
    {
        if ($value > 0) {
            return true;
        } else {
            throw new PhavaException(self::ERROR_ID_INVALID);
        }
    }
}

?>