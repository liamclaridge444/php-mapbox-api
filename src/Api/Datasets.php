<?php

namespace MapboxApi\Api;

use MapboxApi\HttpClient\Response;

/**
 * Datasets API.
 * 
 * @link   https://docs.mapbox.com/api/maps/datasets/
 * 
 * @author Liam Claridge <lclaridge4@gmail.com>
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

    /**
     * List all the datasets that belong to a particular account. This endpoint supports pagination.
     * 
     * @link https://docs.mapbox.com/api/maps/datasets/#list-datasets
     * 
     * @param array $parameters
     * 
     * @return Response
     */
    public function list(array $parameters = []): Response
    {
        return $this->get(sprintf('/%s/%s/%s', self::API_NAME, self::API_VERSION, $this->username()), $parameters);
    }

    /**
     * Retrieve information about a single existing dataset.
     * 
     * @link https://docs.mapbox.com/api/maps/datasets/#retrieve-a-dataset
     * 
     * @param string $datasetId
     * 
     * @return Response
     */
    public function retrieve(string $datasetId): Response
    {
        return $this->get(sprintf('/%s/%s/%s/%s', self::API_NAME, self::API_VERSION, $this->username(), $datasetId));
    }

    /**
     * Create a new, empty dataset.
     * 
     * @link https://docs.mapbox.com/api/maps/datasets/#create-a-dataset
     * 
     * @param array $data
     * 
     * @return Response
     */
    public function create(array $data): Response
    {
        return $this->post(sprintf('/%s/%s/%s', self::API_NAME, self::API_VERSION, $this->username()), $data);
    }

    /**
     * Update the properties of a specific dataset.
     * 
     * @link https://docs.mapbox.com/api/maps/datasets/#update-a-dataset
     * 
     * @param string $datasetId
     * @param array  $data
     * 
     * @return Response
     */
    public function update(string $datasetId, array $data)
    {
        return $this->patch(sprintf('/%s/%s/%s/%s', self::API_NAME, self::API_VERSION, $this->username(), $datasetId), $data);
    }

    /**
     * Delete a specific dataset.
     * 
     * @link https://docs.mapbox.com/api/maps/datasets/#delete-a-dataset
     * 
     * @param string $datasetId
     * 
     * @return Response
     */
    public function remove(string $datasetId)
    {
        return $this->delete(sprintf('/%s/%s/%s/%s', self::API_NAME, self::API_VERSION, $this->username(), $datasetId));
    }
}