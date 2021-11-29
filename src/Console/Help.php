<?php


namespace Webguosai\Console;


class Help
{
    public function handle($param)
    {
        $help = [];
        $help[] = str_pad('name', 30, ' ') . 'desc';

        return implode(PHP_EOL, $help);
    }
}