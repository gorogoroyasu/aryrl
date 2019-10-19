<?php

namespace Arylr;

use InvalidArgumentException;

class Store
{
    use PruneTrait;
    use NameTrait;

    /** @var array $array */
    protected $array = [];
    /** @var array $options */
    protected $options = [
        'row' => 'max',  # or int >= 1
        'col' => 'max',  # or int >= 1
        'fill' => null,
        'columns' => [],
        'others' => 'default',
    ];
    /** @var array $pruned */
    protected $pruned = [];
    /** @var array $named */
    protected $named = [];

    /**
     * @param array $array
     * @param array $options
     */
    public function __construct(array $array=[], array $options=[])
    {
        $this->setArray($array);
        $this->setOptions($options);
        $this->prune();
        $this->name();
    }

    /**
     * @return array
     */
    public function getPruned() : array
    {
        return $this->pruned;
    }

    /**
     * @return array
     */
    public function getNamed() : array
    {
        return $this->named;
    }

    /**
     * @param array $options
     */
    private function setOptions(array $options)
    {
        $opt = $options + $this->options;

        // check option arguments.
        foreach (['row', 'col'] as $target) {
            if (($opt[$target] != 'max') && ((int) $opt[$target] === 0)) {
                throw new InvalidArgumentException("\$options[$target] is invalid.");
            }
        }

        // remove named keys in columns
        if (!empty($opt['columns'])) {
            $cs = [];
            foreach($opt['columns'] as $v) {
                $cs[] = $v;
            }
            $opt['columns'] = $cs;
        }
        $this->options = $opt;
    }

    /**
     * @param array $array
     */
    private function setArray(array $array)
    {
        if (empty($array)) {
            throw new InvalidArgumentException('$options is invalid.');
        }

        # Value Validation
        foreach ($array as $rows) {
            if (!is_array($rows)) throw new InvalidArgumentException('Array have to be 2 dimensional.');
            foreach ($rows as $cols) {
                if (is_array($cols)) throw new InvalidArgumentException('Array have to be 2 dimensional.');
            }
        }

        $this->array = $array;
    }
}