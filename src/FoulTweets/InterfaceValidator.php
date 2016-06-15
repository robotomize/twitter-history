<?php

namespace FoulTweets;

/**
 * Class InterfaceValidator
 * @package FoulTweets
 * @author robotomize@gmail.com
 */
interface InterfaceValidator
{
    /**
     * @param InterfaceModel $model
     * @return mixed
     */
    public static function validate(InterfaceModel $model);
}