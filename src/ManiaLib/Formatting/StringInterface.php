<?php

namespace ManiaLib\Formatting;

interface StringInterface
{
    public function __construct($string);

    /**
     * Remove codes provided from input string
     * @param string $codes
     * @return static
     */
    public function strip($codes);

    /**
     * Remove all styles, colors and links from input string
     * @param string[] $codes
     * @return static
     */
    public function stripAll();

    /**
     * Remove every links from input string
     * @return static
     */
    public function stripLinks();

    /**
     * Remove every colors code from input string
     * Remove
     * @return static
     */
    public function stripColors();

    /**
     * Replace escaped characters by their value
     * i.e: $$ will be replaced by $
     * @return static
     */
    public function stripEscapeCharacters();

    /**
     * Change string colors to increase contrast with backgroundColor
     * @param string $backgroundColor chaine au format RGB12 ou RGB24, i.e FFF ou FFFFFF
     * @return static
     */
    public function contrastColors($backgroundColor);

    /**
     * Return the modified string
     * @return string
     */
    public function __toString();
}