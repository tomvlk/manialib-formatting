<?php

namespace ManiaLib\Formatting;

interface StringInterface
{
    public function __construct($string);

    /**
     * @param string $codes
     * @return static
     */
    public function strip($codes);

    /**
     * @param string $codes
     * @return static
     */
    public function stripAll();

    /**
     * @return static
     */
    public function stripLinks();

    /**
     * @return static
     */
    public function stripColors();

    /**
     * @return static
     */
    public function stripEscapeCharacter();

    /**
     * @param string $backgroundColor
     * @return static
     */
    public function contrastColors($backgroundColor);

    /**
     * @return string
     */
    public function __toString();
}