<?php

namespace ManiaLib\Formatting;

interface ManiaplanetStringInterface
{
    public function __construct($input);

    /**
     * Init string to edit
     * @param string $input
     * @return static
     */
    public function setInput($input);

    /**
     * Return original string
     * @return string
     */
    public function getInput();

    /**
     * Remove codes provided from input string
     * @param string[] $codes
     * @return static
     */
    public function strip(array $codes);

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
     * Change string colors to increase contrast with backgroundColor
     * @param string $backgroundColor chaine au format RGB12 ou RGB24, i.e FFF ou FFFFFF
     * @return static
     */
    public function contrastColors($backgroundColor);

    /**
     * Return the modified string
     * @return string
     */
    public function toString();

    /**
     * Return the modified string
     * @return string
     */
    public function __toString();
}