<?php

namespace ManiaLib\Formatting\Formatters;

abstract class AbstractFormatter
{
    const INTERNAL_LINK = 0x1;
    const EXTERNAL_LINK = 0x2;
    const ITALIC  = 0x1;
    const BOLD    = 0x2;
    const SHADOW  = 0x4;
    const WIDE    = 0x8;
    const NARROW  = 0x10;
    const CAPITAL = 0x20;
    const COLOR   = 0x40;

    /**
     * @var Lexer
     */
    protected $lexer;

    /**
     * @var array
     */
    protected $stylesStack = array();

    /**
     * @var int
     */
    protected $currentStyles;

    /**
     * @var int
     */
    protected $links;

    /**
     * @var string
     */
    protected $formattedString = '';

    public function __construct($string)
    {
        $this->lexer = new Lexer();
        $this->lexer->setInput($string);
    }

    public function getFormattedString()
    {
        while ($this->lexer->moveNext()) {
            switch ($this->lexer->lookahead['type']) {
                case Lexer::T_DOLLAR:
                    $this->addDollar();
                    break;
                case Lexer::T_OPEN_SQUARE_BRACKET:
                    $this->addOpenSquareBracket();
                    break;
                case Lexer::T_CLOSE_SQUARE_BRACKET:
                    $this->addCloseSquareBracket();
                    break;
                case Lexer::T_ITALIC:
                    $this->parseStyle(static::ITALIC, 'startItalic', 'endItalic');
                    break;
                case Lexer::T_BOLD:
                    $this->parseStyle(static::BOLD, 'startBold', 'endBold');
                    break;
                case Lexer::T_SHADOWED:
                    $this->parseStyle(static::SHADOW, 'startShadowed', 'endShadowed');
                    break;
                case Lexer::T_WIDE:
                    $this->closeStyle(static::NARROW, 'endNarrow');
                    $this->parseStyle(static::WIDE, 'startWide', 'endWide');
                    break;
                case Lexer::T_NARROW:
                    $this->closeStyle(static::WIDE, 'endWide');
                    $this->parseStyle(static::NARROW, 'startNarrow', 'endNarrow');
                    break;
                case Lexer::T_CAPITALIZED:
                    $this->parseStyle(static::CAPITAL, 'startCapitalized', 'endCapitalized');
                    break;
                case Lexer::T_COLOR:
                    $color = preg_replace("/([^$0-9a-f])/iu", "0", $this->lexer->lookahead['value']);
                    $this->openStyle(static::COLOR, 'startColor', array($color));
                    break;
                case Lexer::T_EXTERNAL_HIDDEN_LINK:
                    $result = $this->closeLinkIfOpen();
                    if (!$result) {
                        $link = $this->searchLink(true);
                        if($link) {
                            continue;
                        }
                        $this->openLink(static::EXTERNAL_LINK, 'startExternalLink', array($link));
                    }
                    break;
                case Lexer::T_EXTERNAL_LINK:
                    $result = $this->closeLinkIfOpen();
                    if (!$result) {
                        $link = $this->searchLink(false);
                        if(!$link) {
                            continue;
                        }
                        $this->openLink(static::EXTERNAL_LINK, 'startExternalLink', array($link));
                    }
                    break;
                case Lexer::T_INTERNAL_HIDDEN_LINK:
                    $result = $this->closeLinkIfOpen();
                    if (!$result) {
                        $link = $this->searchLink(true);
                        if (!$link) {
                            continue;
                        }
                        $securedLink = $this->secureInternalLink($link);
                        $this->openLink(static::INTERNAL_LINK, 'startInternalLink', array($securedLink));
                    }
                    break;
                case Lexer::T_INTERNAL_LINK:
                    $result = $this->closeLinkIfOpen();
                    if (!$result) {
                        $link = $this->searchLink(false);
                        if(!$link) {
                            continue;
                        }
                        $securedLink = $this->secureInternalLink($link);
                        $this->openLink(static::INTERNAL_LINK, 'startInternalLink', array($securedLink));
                    }
                    break;
                case Lexer::T_OPEN_STACK:
                    array_push($this->stylesStack, $this->currentStyles);
                    $this->startStack();
                    break;
                case Lexer::T_CLOSE_STACK:
                    $previousStyle       = array_pop($this->stylesStack);
                    $this->endStack($this->currentStyles);
                    $this->currentStyles = $previousStyle;
                    break;
                case Lexer::T_RESET_WIDE:
                    $this->closeStyle(static::NARROW, 'endNarrow').
                        $this->closeStyle(static::WIDE, 'endWide');
                    break;
                case Lexer::T_RESET_COLOR:
                    $this->closeStyle(static::COLOR, 'endColor');
                    break;
                case Lexer::T_RESET_STYLES:
                    $this->closeStyle(static::BOLD, 'endBold');
                    $this->closeStyle(static::CAPITAL, 'endCapitalized');
                    $this->closeStyle(static::COLOR, 'endColor');
                    $this->closeLink(static::EXTERNAL_LINK, 'endExternalLink');
                    $this->closeLink(static::INTERNAL_LINK, 'endInternalLink');
                    $this->closeStyle(static::ITALIC, 'endItalic');
                    $this->closeStyle(static::NARROW, 'endNarrow');
                    $this->closeStyle(static::SHADOW, 'endShadowed');
                    $this->closeStyle(static::WIDE, 'endWide');
                    break;
                default:
                    $this->none($this->lexer->lookahead['value']);
            }
        }
        return $this->formattedString;
    }

    protected function isStyleOpen($style)
    {
        return ($this->currentStyles & $style) !== 0;
    }

    protected function isLinkOpen($linkStyle)
    {
        return ($this->links & $linkStyle) !== 0;
    }

    protected function openStyle($style, $methodName, array $params = array())
    {
        $this->currentStyles |= $style;
        call_user_method_array($methodName, $this, $params);
        return true;
    }

    protected function closeStyle($style, $methodName)
    {
        if ($this->isStyleOpen($style)) {
            $this->currentStyles &= ~$style;
            call_user_method($methodName, $this);
            return true;
        }
        return false;
    }

    protected function openLink($linkType, $methodeName, array $params = array())
    {
        $this->links |= $linkType;
        call_user_method_array($methodeName, $this, $params);
        return true;
    }

    protected function closeLink($linkType, $methodName)
    {
        $this->links &= ~$linkType;
        call_user_method($methodName, $this);
        return true;
    }

    protected function closeLinkIfOpen()
    {
        $result = false;
        if ($this->isLinkOpen(static::EXTERNAL_LINK)) {
            $result |= $this->closeLink(static::EXTERNAL_LINK, 'endExternalLink');
        } elseif ($this->isLinkOpen(static::INTERNAL_LINK)) {
            $result |= $this->closeLink(static::INTERNAL_LINK, 'endInternalLink');
        }
        return $result;
    }

    protected function parseStyle($style, $openStyleMethod, $endStyleMethod,
                                  array $openStyleParams = array())
    {
        $result = false;
        $result |= $this->closeStyle($style, $endStyleMethod);
        if (!$result) {
            $result |= $this->openStyle($style, $openStyleMethod, $openStyleParams);
        }
        return $result;
    }

    protected function searchLink($isHidden)
    {
        if (!$isHidden) {
            $link          = '';
            $endLinkTokens = array(
                Lexer::T_EXTERNAL_HIDDEN_LINK,
                Lexer::T_EXTERNAL_LINK,
                Lexer::T_INTERNAL_HIDDEN_LINK,
                Lexer::T_INTERNAL_LINK,
                Lexer::T_RESET_STYLES
            );
            do {
                $nextLookahead = $this->lexer->peek();
                if ($nextLookahead && $nextLookahead['type'] == Lexer::T_NONE) {
                    $link .= $nextLookahead['value'];
                }
            } while ($nextLookahead !== null && !in_array($nextLookahead['type'], $endLinkTokens));
            if(substr($link, 0, 1) == '[') {
                $link = false;
                while($this->lexer->lookahead != $nextLookahead) {
                    $this->lexer->moveNext();
                }
            }
        } else {
            $this->lexer->moveNext();
            $matches = array();
            if(preg_match('/^\[([^\]]*)\]$/iu', $this->lexer->lookahead['value'], $matches)) {
                $link = $matches[1];
            }else {
                $link = false;
            }
        }
        return $link;
    }

    protected function secureInternalLink($link)
    {
        $protocol = 'maniaplanet://';
        if (substr($link, 0, strlen($protocol)) != $protocol) {
            $link = sprintf('maniaplanet:///:%s', $link);
        }
        return $link;
    }

    protected abstract function addDollar();

    protected abstract function addOpenSquareBracket();

    protected abstract function addCloseSquareBracket();

    protected abstract function startItalic();

    protected abstract function endItalic();

    protected abstract function startBold();

    protected abstract function endBold();

    protected abstract function startShadowed();

    protected abstract function endShadowed();

    protected abstract function startWide();

    protected abstract function endWide();

    protected abstract function startNarrow();

    protected abstract function endNarrow();

    protected abstract function startCapitalized();

    protected abstract function endCapitalized();

    protected abstract function startColor($color);

    protected abstract function endColor();

    protected abstract function startInternalLink($link);

    protected abstract function endInternalLink();

    protected abstract function startExternalLink($link);

    protected abstract function endExternalLink();

    protected abstract function startStack();

    protected abstract function endStack($previousStack);

    protected abstract function none($text);
}