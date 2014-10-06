<?php

namespace ManiaLib\Formatting\Formatters;

use ManiaLib\Formatting\Color;

class HTMLFormatter extends AbstractFormatter
{
    protected $backgroundColor = '';
    protected $htmlStyles      = array();
    protected $htmlStylesStack = array();
    protected $link;

    public function __construct($string, $backgroundColor = '')
    {
        parent::__construct($string);
        if ($backgroundColor) {
            $this->backgroundColor = Color::StringToRgb24($backgroundColor);
        }
    }

    protected function startBold()
    {
        $this->htmlStyles['bold'] = 'font-weight:bold;';
    }

    protected function endBold()
    {
        $this->htmlStyles['bold'] = '';
    }

    protected function startCapitalized()
    {
        $this->htmlStyles['capitalized'] = 'text-transform:uppercase;';
    }

    protected function endCapitalized()
    {
        $this->htmlStyles['capitalized'] = '';
    }

    protected function startColor($color)
    {
        $color = Color::StringToRgb24($color);
        if ($this->backgroundColor) {
            $color = Color::Contrast($color, $this->backgroundColor);
        }
        $this->htmlStyles['color'] = sprintf('color:#%s;', Color::Rgb24ToString($color));
    }

    protected function endColor()
    {
        return $this->htmlStyles['color'] = '';
    }

    protected function startItalic()
    {
        $this->htmlStyles['italic'] = 'font-style:italic;';
    }

    protected function endItalic()
    {
        $this->htmlStyles['italic'] = '';
    }

    protected function startNarrow()
    {
        $this->htmlStyles['narrow'] = 'letter-spacing:-.1em;font-size:95%;';
    }

    protected function endNarrow()
    {
        $this->htmlStyles['narrow'] = '';
    }

    protected function startShadowed()
    {
        $this->htmlStyles['shadow'] = 'text-shadow:1px 1px 1px rgba(0,0,0,.5);';
    }

    protected function endShadowed()
    {
        $this->htmlStyles['shadow'] = '';
    }

    protected function startWide()
    {
        $this->htmlStyles['narrow'] = 'letter-spacing:.1em;font-size:105%;';
    }

    protected function endWide()
    {
        $this->htmlStyles['narrow'] = '';
    }

    protected function startStack()
    {
        array_push($this->htmlStylesStack, $this->htmlStyles);
    }

    protected function endStack($previousStack)
    {
        $this->htmlStyles = array_pop($this->htmlStylesStack);
    }

    protected function startExternalLink($link)
    {
        $this->link = $link;
    }

    protected function endExternalLink()
    {
        $this->link = null;
    }

    protected function startInternalLink($link)
    {
        $this->link = $link;
    }

    protected function endInternalLink()
    {
        $this->link = null;
    }

    protected function addDollar()
    {
        $this->formattedString .= $this->none('$');
    }

    protected function addOpenSquareBracket()
    {
        $this->formattedString .= $this->none('[');
    }
    
    protected function addCloseSquareBracket()
    {
        $this->formattedString .= $this->none(']');
    }

    protected function none($text)
    {
        if ($this->currentStyles) {
            $text = sprintf(
                '<span style="%s">%s</span>',
                implode('', $this->htmlStyles),
                htmlentities($text, ENT_QUOTES, 'UTF-8'));
        }
        if ($this->link) {
            $text = sprintf('<a href="%s" style="color:inherit">%s</a>', $this->link, $text);
        }
        $this->formattedString .= $text;
    }
}