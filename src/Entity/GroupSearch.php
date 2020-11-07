<?php
namespace App\Entity;

class GroupSearch
{
    /**
     * @var boolean
     */
    private $filterGroup;

    /**
     * GroupSearch constructor.
     * @param bool $filterGroup
     */
    public function __construct()
    {
        $this->filterGroup = false;
    }


    /**
     * @return bool
     */
    public function isFilterGroup(): bool
    {
        return $this->filterGroup;
    }

    /**
     * @param bool $filterGroup
     * @return GroupSearch
     */
    public function setFilterGroup(bool $filterGroup): GroupSearch
    {
        $this->filterGroup = $filterGroup;
        return $this;
    }
}