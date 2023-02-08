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
    const CATEGORY_ID = 'category_id';
    const STATUS = 'status';
    const CREATED_AT= 'created_at';
    const UPDATED_AT= 'updated_at';
    const PUBLISH_DATE= 'publish_date';

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
    public function getCategoryId();
    public function getStatus();
    public function getCreatedAt();
    public function getUpdatedAt();
    public function getPublishDate();

    public function setTitle(string $title);
    public function setUrlKey(string $urlKey);
    public function setContent(string $content);
    public function setTags(string $tags);
    public function setCategoryId(string $category);
    public function setStatus(int $status);
    public function setCreatedAt($createdAt);
    public function setUpdatedAt($updatedAt);
    public function setPublishDate($publishDate);
}
