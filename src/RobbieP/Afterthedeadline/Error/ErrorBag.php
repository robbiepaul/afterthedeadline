<?php namespace RobbieP\Afterthedeadline\Error;


class ErrorBag
{
    protected static $errors = [
        'spelling' => 'RobbieP\Afterthedeadline\Error\Spelling',
        'suggestion' => 'RobbieP\Afterthedeadline\Error\Suggestion',
        'grammar' => 'RobbieP\Afterthedeadline\Error\Grammar',
    ];

    /**
     * @param $type
     * @param array $data
     * @return mixed
     */
    public static function get($type, $data = [])
    {
        if(in_array($type, array_keys(self::$errors))) {
            $class = self::$errors[$type];
            return new $class($data);
        }

    }
}