<?php

namespace Alyona\PostEAV\Api\Data;

interface PostInterface
{
    const TABLE = 'alyona_posteav';
    const ID = 'post_id';
    const TITLE = 'title';
    const URL_KEY = 'url_key';
    const POST_CONTENT = 'post_content';
    const TAGS= 'tags';
    const CATEGORY = 'category_id';
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

    public function getTitle();
    public function getUrlKey();
    public function getPostContent();
    public function getTags();
    public function getCategory();
    public function getStatus();
    public function getCreatedAt();
    public function getUpdatedAt();

    public function setTitle(string $title);
    public function setUrlKey(string $urlKey);
    public function setContent(string $content);
    public function setTags(string $tags);
    public function setCategory(string $category);
    public function setStatus(bool $status);
    public function setCreatedAt($createdAt);
    public function setUpdatedAt($updatedAt);
}
