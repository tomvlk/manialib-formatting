<?php
// Both solutions can be used in our current code to replace static methods

$referenceString = 'Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse $tmajuscule$m avec un $l[lien]lien externe$l et $h[lien]lien interne$h';

$muttable = new \ManiaLib\Formatting\ManiaplanetStringMutable($referenceString);
echo $muttable->stripLinks()->strip('t');
// output:
// Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse majuscule$m avec un lien externe et lien interne
echo $muttable->strip('t');
// output:
// Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse majuscule$m avec un lien externe et lien interne
echo $muttable->strip();
// output:
// Ceci est une chaine Bleue Italique protégée large ou étroite ombrée grasse majuscule avec un lien externe et lien interne
echo $muttable->stripColors()->stripLinks()->toHTML();
// output:
// Ceci est une chaine Bleue Italique protégée large ou étroite ombrée grasse majuscule avec un lien externe et lien interne
echo $muttable->restore();
// output:
// Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse $tmajuscule$m avec un $l[lien]lien externe$l et $h[lien]lien interne$h


// ManiaplanetString should be immutable. That way we have one instance for one string and formatted it in many different ways.
// One of the best usage for this class is nickname string in Player object or server name in Server object

$immutable = new ManiaLib\Formatting\ManiaplanetString($referenceString);
echo $immutable->stripLinks()->strip('t');
// output:
// Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse majuscule$m avec un lien externe et lien interne
echo $immutable->strip('t');
// output:
// Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse majuscule$m avec un $l[lien]lien externe$l et $h[lien]lien interne$h
echo $immutable->strip();
// output:
// Ceci est une chaine Bleue Italique protégée large ou étroite ombrée grasse majuscule avec un lien externe et lien interne
echo (new ManiaLib\Formatting\Formatters\HTMLFormatter($immutable->stripColors()->stripLinks()))->getFormattedString();
// output:
// Ceci est une chaine Bleue <span style="font-style:italic;">Italique prot&eacute;g&eacute;e </span>
// <span style="font-style:italic;letter-spacing:.1em;font-size:105%;">large ou </span>
// <span style="font-style:italic;letter-spacing:-.1em;font-size:95%;">&eacute;troite </span>
// <span style="font-style:italic;text-shadow:1px 1px 1px rgba(0,0,0,.5);letter-spacing:-.1em;font-size:95%;">ombr&eacute;e </span>
// <span style="font-style:italic;font-weight:bold;text-shadow:1px 1px 1px rgba(0,0,0,.5);letter-spacing:-.1em;font-size:95%;">grasse </span>
// <span style="font-style:italic;font-weight:bold;text-shadow:1px 1px 1px rgba(0,0,0,.5);letter-spacing:-.1em;font-size:95%;">MAJUSCULE AVEC</span>
// <span style="font-style:italic;font-weight:bold;text-shadow:1px 1px 1px rgba(0,0,0,.5);"> UN</span> lien externe et lien interne