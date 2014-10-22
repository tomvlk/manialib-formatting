<?php

namespace ManiaLib\Formatting;

interface ConverterInterface
{

    public function __construct($string);

    public function getResult();
}