<?php
declare(strict_types=1);
namespace Alyona\Post\Api\Data;

interface PostInterface
{
    const ID = 'post_id';
    const TITLE = 'title';
    const CONTENT = 'content';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function getId():int;
    public function getTitle():string;
    public function getContent():string;
    public function getCreatedAt():string;
    public function getUpdatedAt():string;

    public function setId($id);
    public function setTitle($title);
    public function setContent($content);
    public function setCreatedAt($createdAt);
    public function setUpdatedAt($updatedAt);
}
