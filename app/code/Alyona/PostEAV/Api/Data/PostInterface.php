<?php

namespace Alyona\PostEAV\Api\Data;

interface PostInterface
{
    /**
     * @return mixed|null
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id);

}
