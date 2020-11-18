<?php
namespace App\LayerService\Objects;

use \App\LayerService\Objects\PhavaException;

/**
 * @author Pouya
 */
class PhavaText
{
    /**
     * Error constants.
     */
    const ERROR_TEXT_INVALID = 'The provided text is not valid.';

    /**
     * @var string
     */
    protected $textString;

    /**
     * @param string $textString
     */
    public function __construct(string $textString)
    {
        static::assertTextValid($textString);

        $this->textString = $textString;
    }

    /**
     * @return string
     */
    public function getTextString(): string
    {
        return $this->textString;
    }

    /**
     * @param string $textString
     *
     * @return bool
     * @throws PhavaException
     */
    private static function assertTextValid(string $textString): bool
    {
        if (strlen($textString) > 0) {
            return true;
        } else {
            throw new PhavaException(self::ERROR_TEXT_INVALID);
        }
    }
}

?>