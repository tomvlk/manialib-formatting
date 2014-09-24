<?php
//Example of usage of ManiaLib/Formatting/FormatterInterface all in 1 class
//In this example the Formatter class implements the FormatterInterface
//In this case I consider the Formatter object as mutable object
$referenceString = 'Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse $tmajuscule$m avec un $l[lien]lien externe$l et $h[lien]lien interne$h';
$formatter = new ManiaLib\Formatting\Formatter($referenceString);
echo $formatter->stripLinks()->strip('t');
// output:
// Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse majuscule$m avec un lien externe et lien interne
echo $formatter->strip('t');
// output:
// Ceci est une chaine $00FBleue $iItalique $<$i$f00protégée$> $wlarge$g ou $nétroite $sombrée $ograsse majuscule$m avec un lien externe et lien interne
echo $formatter->strip();
// output:
// Ceci est une chaine Bleue Italique protégée large ou étroite ombrée grasse majuscule avec un lien externe et lien interne
echo $formatter->stripColors()->stripLinks()->toHTML();
// output:
// Ceci est une chaine Bleue Italique protégée large ou étroite ombrée grasse majuscule avec un lien externe et lien interne

