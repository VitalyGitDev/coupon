<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 25.11.18
 * Time: 9:53
 */
namespace Application\Services;

use Application\Core\Service;

class DataFetcher extends Service
{
    /**
     * Configured repositories.
     *
     * @var mixed
     */
    protected $dataRepos;

    /**
     * Data received from remote repositories.
     *
     * @var array
     */
    public $data = [];

    /**
     * DataFetcher Service constructor.
     *
     * DataFetcher constructor.
     * @param $dataFetcherConfig
     */
    public function __construct($dataFetcherConfig)
    {
        $this->dataRepos = include_once($dataFetcherConfig);
        $this->fetch();
    }

    /**
     * Fetch data from configured repositories.
     *
     * @param null $alias
     */
    public function fetch($alias = null) : void
    {
        $this->data = [];
        if ($alias && !empty($this->dataRepos[$alias]))
            $this->requestRepo($this->dataRepos[$alias]);

//  Should be uncommented in case using multiple repositories.
//        else
//            foreach ($this->dataRepos as $resourceAlias => $resourceCfg) {
//                $this->requestRepo($resourceCfg);
//            }
    }

    /**
     * Makes a request to configured repository.
     *
     * @param $repoCfg
     */
    protected function requestRepo($repoCfg) : void
    {
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, $repoCfg['url']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            if (!empty($repoCfg['authentication'])) {
                $authCfg = $repoCfg['authentication'];
                curl_setopt($curl, CURLOPT_HTTPHEADER, [ $authCfg['field'] . ': ' .  $authCfg['value']]);
            }
            $res = curl_exec($curl);
            // TODO: $res parser/checker needs to be here.
            if ($res) {
                $this->data = array_merge($this->data, json_decode($res, true));
            }
            curl_close($curl);
        }
    }
}