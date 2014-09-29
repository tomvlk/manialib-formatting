<?php

namespace ManiaLib\Formatting;

class ManiaplanetString extends AbstractManiaplanetString
{

    public function contrastColors($backgroundColor)
    {
        return new static($this->doContrastColors($backgroundColor));
    }

    public function strip(string $codes = array())
    {
        return new static($this->doStrip($codes));
    }

    public function stripColors()
    {
        return new static($this->doStripColors());
    }

    public function stripLinks()
    {
        return new static($this->doStripLinks());
    }
}