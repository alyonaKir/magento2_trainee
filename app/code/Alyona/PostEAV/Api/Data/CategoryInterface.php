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

    public function getName();
    public function getUrlKey();

    public function getStatus();
    public function getCreatedAt();
    public function getUpdatedAt();

    public function setname(string $name);
    public function setUrlKey(string $urlKey);
    public function setStatus(bool $status);
    public function setCreatedAt($createdAt);
    public function setUpdatedAt($updatedAt);
}
