<?php

namespace Arylr;
use InvalidArgumentException;

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

    protected function namedT()
    {
        $p = $this->named;
        $ret = [];
        foreach ($p as $kRow => $row) {
            foreach ($row as $kCol => $col) {
                $ret[$kCol][$kRow] = $col;
            }
        }
        $this->namedT = $ret;
    }

    private function uniq($key)
    {
        $named = $this->getNamedT();

        if ($key == $this->options['others']) {
            return [];
        }

        $uniqueness = [];
        foreach ($named[$key] as $k => $item) {
            $uniqueness[$item][] = $k;
        }

        return array_filter($uniqueness, function ($v) {
            return count($v) >= 2;
        });
    }

    protected function namedUniqueness($columnName=null)
    {
        if (!is_null($columnName)) {
            return $this->uniq($columnName);
        }

        $named = $this->getNamedT();
        $keys = array_keys($named);
        $uniq = [];
        foreach ($keys as $key) {
            $u = $this->uniq($key);
            if (!empty($u)) {
                $uniq[$key] = $u;
            }
        }
        return $uniq;
    }

    protected function nameUnique($columnName=null)
    {
        return empty($this->namedUniqueness($columnName));
    }
}