<?php 

abstract class AbstractBrand {

    protected $name;

    abstract protected function getTva();
    abstract protected function getFraisTransport();
}