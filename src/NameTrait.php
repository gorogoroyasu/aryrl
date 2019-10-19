<?php

namespace Arylr;

trait NameTrait
{
    protected function name()
    {
        $columns = $this->options['columns'];

        $pruned = $this->pruned;

        $columnDefLen = count($columns);
        $ret = [];
        foreach ($pruned as $key => $row) {
            $ret[$key] = [];
            foreach ($row as $k => $c) {
                if ($k < $columnDefLen) {
                    $ret[$key][$columns[$k]] = $c;
                } else {
                    $ret[$key][$this->options['others']][] = $c;
                }

            }
        }
        $this->named = $ret;
    }
}