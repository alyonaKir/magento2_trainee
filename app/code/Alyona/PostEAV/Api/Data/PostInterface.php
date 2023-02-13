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

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @return mixed
     */
    public function getUrlKey();

    /**
     * @return mixed
     */
    public function getPostContent();

    /**
     * @return mixed
     */
    public function getTags();

    /**
     * @return mixed
     */
    public function getCategoryId();

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
     * @return mixed
     */
    public function getPublishDate();

    /**
     * @param string $title
     * @return mixed
     */
    public function setTitle(string $title);

    /**
     * @param string $urlKey
     * @return mixed
     */
    public function setUrlKey(string $urlKey);

    /**
     * @param string $content
     * @return mixed
     */
    public function setContent(string $content);

    /**
     * @param string $tags
     * @return mixed
     */
    public function setTags(string $tags);

    /**
     * @param string $category
     * @return mixed
     */
    public function setCategoryId(string $category);

    /**
     * @param int $status
     * @return mixed
     */
    public function setStatus(int $status);

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

    /**
     * @param $publishDate
     * @return mixed
     */
    public function setPublishDate($publishDate);
}
