<?php
//Example of usage of ManiaLib/Formatting/FormatterInterface all in 1 class
//In this example the Formatter class implements the FormatterInterface
$referenceString = 'Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse $tmajuscule$m avec un $l[lien]lien externe$l et $h[lien]lien interne$h';
$formatter = new ManiaLib/Formatting/Formatter();
echo $formatter->stripLinks()->strip('t');
// output:
// Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse majuscule$m avec un lien externe et lien interne
echo $formatter->strip('t');
// output:
// Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse majuscule$m avec un $l[lien]lien externe$l et $h[lien]lien interne$h
echo $formatter->strip();
// output:
// Ceci est une chaine Bleue Italique protégée large ou étroite ombrée grasse majuscule avec un lien externe et lien interne
echo $formatter->stripColors()->stripLinks()->toHTML();
// output:
// Ceci est une chaine Bleue <span style="font-style:italic;">Italique prot&eacute;g&eacute;e </span>
// <span style="font-style:italic;letter-spacing:.1em;font-size:105%;">large ou </span>
// <span style="font-style:italic;letter-spacing:-.1em;font-size:95%;">&eacute;troite </span>
// <span style="font-style:italic;text-shadow:1px 1px 1px rgba(0,0,0,.5);letter-spacing:-.1em;font-size:95%;">ombr&eacute;e </span>
// <span style="font-style:italic;font-weight:bold;text-shadow:1px 1px 1px rgba(0,0,0,.5);letter-spacing:-.1em;font-size:95%;">grasse </span>
// <span style="font-style:italic;font-weight:bold;text-shadow:1px 1px 1px rgba(0,0,0,.5);letter-spacing:-.1em;font-size:95%;">MAJUSCULE AVEC</span>
// <span style="font-style:italic;font-weight:bold;text-shadow:1px 1px 1px rgba(0,0,0,.5);"> UN</span> lien externe et lien interne

