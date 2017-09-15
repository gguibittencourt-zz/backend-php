<?php


interface Filter{
    function addCondition($field, $value);
    public function getConditions();
    public function getFields();
}