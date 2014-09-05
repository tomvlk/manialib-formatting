<?php

namespace ManiaLib\Formatting;

interface FormatterInterface
{

    public function __construct($input);

    /**
     * Initialise la chaine à transformer
     * @param string $input
     * @return \static
     */
    public function setInput($input);

    /**
     * Retourne la chaine original
     * @return string
     */
    public function getInput();

    /**
     * Supprime les codes fournis de la chaine
     * @param string[] $code
     * @return \static
     */
    public function stripCodes(array $code);

    /**
     * Supprime tout les styles de la chaine
     * @return \static
     */
    public function stripStyles();

    /**
     * Supprime tout les liens de la chaine
     * @return \static
     */
    public function stripLinks();

    /**
     * Supprime tout les codes liés aux couleurs de la chaine
     * @return \static
     */
    public function stripColors();

    /**
     * Supprime les formatages relatifs à la largeur des caractères dans la chaine
     * @return \static
     */
    public function stripWideFonts();

    /**
     * Modifie les couleurs de la chaine pour améliorer le contraste par rapport à la couleur fournie
     * @param string $backgroundColor chaine au format RGB12 ou RGB24, i.e FFF ou FFFFFF
     * @return \static
     */
    public function contrastColots($backgroundColor);

    /**
     * Retourne la chaine modifiée
     * @return string
     */
    public function toString();


    /**
     * Retourne la chaine modifiée au format HTML
     * @return string
     */
    public function toHTML();

    /**
     * Retourne la chaine modifiée
     * @return string
     */
    public function __toString();

    /**
     * Incruste la chaine modifiée sur l'image fournie
     * @param ressource $image Ressource d'image créée avec gd2
     * @param string $fontName Chemin vers la police TTF
     * @param int $x position
     * @param int $y position
     * @param int $size taille de la police
     * @param type $defaultColor Default text color in 3 or 6 hexadecimal characters
     * @return void
     */
    public function toImage($image, $fontName, $x = 0, $y = 0, $size = 10, $defaultColor = '000');
}