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

        $counts = array_map(function ($a) {
            return count($a);
        }, $this->array);
        $maxRow = count($counts);
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

}