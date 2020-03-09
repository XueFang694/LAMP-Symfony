<?php

namespace App\Utils\Script;

interface ScriptInterface
{
    public function getLabel();
    public function setLabel();

    public function getScriptName();
    public function setScriptName();

    public function getScriptPath();
    public function setScriptPath();

    public function getArguments();
    public function setArguments();
}