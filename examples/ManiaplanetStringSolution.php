<?php
//Example of usage of ManiaLib/Formatting/ManiaplanetString
//I consider for this example that the ManiaplanetString object is immutable
$referenceString = 'Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse $tmajuscule$m avec un $l[lien]lien externe$l et $h[lien]lien interne$h';
$mpString = new ManiaLib\Formatting\ManiaplanetStringInterface($referenceString);
echo $mpString->stripLinks()->strip('t');
// output:
// Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse majuscule$m avec un lien externe et lien interne
echo $mpString->strip('t');
// output:
// Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse majuscule$m avec un $l[lien]lien externe$l et $h[lien]lien interne$h
echo $mpString->strip();
// output:
// Ceci est une chaine Bleue Italique protégée large ou étroite ombrée grasse majuscule avec un lien externe et lien interne
echo (new ManiaLib\Formatting\Formatters\HTMLFormatter($mpString->stripColors()->stripLinks()))->getFormattedString();
// output:
// Ceci est une chaine Bleue <span style="font-style:italic;">Italique prot&eacute;g&eacute;e </span>
// <span style="font-style:italic;letter-spacing:.1em;font-size:105%;">large ou </span>
// <span style="font-style:italic;letter-spacing:-.1em;font-size:95%;">&eacute;troite </span>
// <span style="font-style:italic;text-shadow:1px 1px 1px rgba(0,0,0,.5);letter-spacing:-.1em;font-size:95%;">ombr&eacute;e </span>
// <span style="font-style:italic;font-weight:bold;text-shadow:1px 1px 1px rgba(0,0,0,.5);letter-spacing:-.1em;font-size:95%;">grasse </span>
// <span style="font-style:italic;font-weight:bold;text-shadow:1px 1px 1px rgba(0,0,0,.5);letter-spacing:-.1em;font-size:95%;">MAJUSCULE AVEC</span>
// <span style="font-style:italic;font-weight:bold;text-shadow:1px 1px 1px rgba(0,0,0,.5);"> UN</span> lien externe et lien interne