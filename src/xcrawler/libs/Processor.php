<?php

namespace xcrawler\libs;

abstract class Processor{
    abstract protected function process($sContents, $sStyleSheet);
}