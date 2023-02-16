<?php

namespace Alyona\PostEAV\Api\Data;

interface CommentInterface
{
    const TABLE = 'alyona_posteav_comments';
    const ID = 'comment_id';
    const NAME = 'name';
    const TEXT = 'text';
    const POST = 'post';

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
     * @param string $name
     * @return mixed
     */
    public function setName(string $name);

    /**
     * @return mixed
     */
    public function getText();

    /**
     * @param string $name
     * @return mixed
     */
    public function setText(string $text);

    /**
     * @return mixed|null
     */
    public function getPost();

    /**
     * @param int $id
     * @return $this
     */
    public function setPost(int $post);
}
