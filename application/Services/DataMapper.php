<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 25.11.18
 * Time: 20:58
 */
namespace Application\Services;

use Application\Core\Model;
use Application\Core\Service;

class DataMapper extends Service
{
    /**
     * Configured patterns for mapping field names.
     *
     * @var mixed
     */
    protected $patterns;

    protected $currentPattern = null;

    protected $inbound = [];

    public $processed = [];

    /**
     * DataMapper Service constructor.
     *
     * @param $dataMapperConfig
     */
    public function __construct($dataMapperConfig)
    {
        $this->patterns = include_once($dataMapperConfig);
    }


    public function map(array $inbound, $patternName) : ?array
    {
        $this->inbound = $inbound;
        if (!empty($this->patterns[$patternName])) {
            $this->currentPattern = $this->patterns[$patternName];
            foreach($this->inbound as $itemKey => $itemValue) {
                $this->process($itemKey, $itemValue);
            }
            return $this->processed;
        } else
            return null;
    }

    protected function process($oldKey, $value) : void
    {
        if (!empty($this->currentPattern[$oldKey])) {
            $mapping = $this->currentPattern[$oldKey];

            switch (gettype($mapping)) {
                case 'string' :
                    $this->processed[$mapping] = (stripos($mapping, 'date') === false)
                        ? $value
                        : $this->parseDateTime($value);
                        break;
                case 'array' : $this->processed[$mapping['map_to']] = $this->getEntity($mapping, $value);
                        break;
            }
        }
    }

    protected function getEntity($conf, $value) : ?int
    {
        $modelClass = $conf['class'];
        /** @var Model $model */
        $model = $modelClass::where([$conf['identify_by'] => $value])->first();
        if (empty($model)) {
            $params = [$conf['identify_by'] => $value];

            //TODO: Must be in separate method!
            if (!empty($conf['additional_args'])) {
                foreach($conf['additional_args'] as $newKey => $oldKey) {
                    if (!empty($this->inbound[$oldKey]))
                        $params[$newKey] = $this->inbound[$oldKey];
                }
            }

            $model = new $modelClass($params);
            $model->save();
        }
        return (!empty($model)) ? $model->id : null;
    }

    protected function parseDateTime($rawDateTime)
    {
        $formatted = new \DateTime($rawDateTime);
        return $formatted->format('Y-m-d H:i:s');
    }
}