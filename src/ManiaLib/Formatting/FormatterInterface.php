<?php

namespace ManiaLib\Formatting;

interface FormatterInterface
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
     * if no code are provided all styles, colors and links will be stripped
     * @param string[] $codes
     * @return static 
     */
    public function strip(array $codes = array());

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
     * Return the modified string in HTML
     * @return string
     */
    public function toHTML();

    /**
     * Return the modified string
     * @return string
     */
    public function __toString();

    /**
     * Draw a string with on an image, method will be choose depending on the size wanted
     * @param imageResource $image The image to draw on
     * @param string $fontName The TTF font to use, which has been declared previously
     * @param int $x position
     * @param int $y position
     * @param int $size Font size
     * @param type $defaultColor Default text color in 3 or 6 hexadecimal characters
     * @return void
     */
    public function toImage($image, $fontName, $x = 0, $y = 0, $size = 10, $defaultColor = '000');
}