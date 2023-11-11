<?php

namespace MapboxApi\Api;

/**
 * Datasets API.
 * 
 * @link   https://docs.mapbox.com/api/maps/datasets/
 */
class Datasets extends AbstractApi
{
    /**
     * @var string
     */
    const API_VERSION = 'v1';

    /**
     * @var string
     */
    const API_NAME = 'datasets';

    public function list(array $parameters = [])
    {
        return $this->get(sprintf('/%s/%s/%s', self::API_NAME, self::API_VERSION, $this->username()), $parameters);
    }

    public function retrieve(string $datasetId)
    {
        return $this->get(sprintf('/%s/%s/%s/%s', self::API_NAME, self::API_VERSION, $this->username(), $datasetId));
    }

    public function create(array $data)
    {
        return $this->post(sprintf('/%s/%s/%s', self::API_NAME, self::API_VERSION, $this->username()), $data);
    }

    /*public function update(string $datasetId, array $data)
    {
        return $this->patch(sprintf('/datasets/%s/%s/%s', $this->apiVersion, $this->username(), $datasetId), $data);
    }*/

    /*public function delete(string $datasetId, array $data)
    {
        return $this->delete(sprintf('/datasets/%s/%s/%s', $this->apiVersion, $this->username(), $datasetId), $data);
    }*/
}