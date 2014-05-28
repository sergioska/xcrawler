<?php

namespace xcrawler;

abstract class Processor{
    abstract protected function process($sContents, $sStyleSheet);
}