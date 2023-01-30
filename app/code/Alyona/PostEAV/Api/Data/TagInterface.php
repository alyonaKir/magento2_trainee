<?php

namespace Alyona\PostEAV\Api\Data;

interface TagInterface
{
    const TABLE = 'alyona_posteav_tags';
    const ID = 'tag_id';
    const NAME = 'name';


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

    public function setName(string $name);

}
