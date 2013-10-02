<?php

abstract class AbstractProcessor{
	abstract protected function process($sContents, $sStyleSheet);
}