<?php
namespace Arylr;

trait PruneTrait
{
    /**
     * @return array
     */
    protected function judgeEnd() : array
    {
        $optRow = $this->options['row'];
        $optCol = $this->options['col'];

        if ($optRow !== 'max' && $optCol !== 'max') {
            return ['row' => $optRow, 'col' => $optCol];
        }

        $array = $this->array;

        $counts = array_map(function ($a) {
            $count = 0;
            # drop empty column at the end of columns
            if ($this->options['drop']) {
                foreach ($a as $k => $v) {
                    if ($v !== $this->options['fill']) {
                        $count = $k + 1;
                    }
                }
            } else {
                $count = count($a);
            }
            return $count;
        }, $array);

        # drop empty row at the end of rows
        if ($this->options['drop']) {
            $rows = -1;
            foreach ($array as $key => $value) {
                $u = array_unique($value);
                if (count($u) !== 1 || array_values($u)[0] !== $this->options['fill']) {
                    $rows = $key + 1;
                }
            }
            if ($rows > 0) {
                $array = array_slice($array, 0, $rows);
            }
        }


        $maxRow = count($array);
        $maxCol = max($counts);


        if ((int)$optRow !== 0 && $optRow <= $maxRow) $maxRow = $optRow;
        if ((int)$optCol !== 0 && $optCol <= $maxCol) $maxCol = $optCol;

        return ['row' => $maxRow, 'col' => $maxCol];
    }

    /**
     * @param $maxCol
     * @return array
     */
    protected function cutCols($maxCol) : array
    {
        return array_map(function ($v) use ($maxCol) {
            $c = count($v);
            if ($c < $maxCol) {
                for ($i=0; $i<$maxCol; $i++) {
                    if ($i>=$c) {
                        $v[$i] = $this->options['fill'];
                    }
                }
            }
            return array_slice($v, 0, $maxCol);
        }, $this->array);
    }

    /**
     * @param array $coled
     * @param int $maxRow
     * @return array
     */
    protected function cutRows(array $coled, $maxRow) : array
    {
        $count = count($coled);
        if ($count < $maxRow) {
            for ($i=0; $i < $maxRow; $i++) {
                if ($i >= $count) {
                    $coled[$i] = array_fill(0, $maxRow, $this->options['fill']);
                }
            }
        }
        return $coled;
    }

    protected function prune()
    {
        $limits = $this->judgeEnd();
        $maxCol = $limits['col'];
        $maxRow = $limits['row'];

        $coled = $this->cutCols($maxCol);
        $coled = $this->cutRows($coled, $maxRow);
        $this->pruned = array_slice($coled, 0, $maxRow);
    }

    protected function prunedT()
    {
        $p = $this->pruned;
        $ret = [];
        foreach ($p as $kRow => $row) {
            foreach ($row as $kCol => $col) {
                $ret[$kCol][$kRow] = $col;
            }
        }
        $this->prunedT = $ret;
    }
}