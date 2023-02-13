<?php

namespace Alyona\PostEAV\Api\Data;

interface CategoryInterface
{
    const TABLE = 'alyona_posteav_category';
    const ID = 'category_id';
    const NAME = 'name';
    const URL_KEY = 'url_key';
    const STATUS = 'status';
    const CREATED_AT= 'created_at';
    const UPDATED_AT= 'updated_at';

    /**
     * @return mixed|null
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id);

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getUrlKey();

    /**
     * @return mixed
     */
    public function getStatus();

    /**
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * @return mixed
     */
    public function getUpdatedAt();

    /**
     * @param string $name
     * @return mixed
     */
    public function setname(string $name);

    /**
     * @param string $urlKey
     * @return mixed
     */
    public function setUrlKey(string $urlKey);

    /**
     * @param bool $status
     * @return mixed
     */
    public function setStatus(bool $status);

    /**
     * @param $createdAt
     * @return mixed
     */
    public function setCreatedAt($createdAt);

    /**
     * @param $updatedAt
     * @return mixed
     */
    public function setUpdatedAt($updatedAt);
}
