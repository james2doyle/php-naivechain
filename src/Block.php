<?php

namespace Blockchain\Naivechain;

class Block
{
    /**
     * @var int
     */
    protected $index;

    /**
     * @var string
     */
    protected $previousHash;

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $data;

    /**
     * @var string
     */
    protected $hash;

    /**
     * Create the Block
     * @param int $index  the index of the new block
     * @param string $previousHash  the has of the previous block
     * @param int $timestamp  the timestamp for the change
     * @param type $data  the data to save in the block
     * @param string $hash  the has to assign to the block
     * @return Block
     */
    public function __construct(int $index, string $previousHash, int $timestamp, string $data, string $hash)
    {
        $this->index = $index;
        $this->previousHash = $previousHash;
        $this->timestamp = $timestamp;
        $this->data = $data;
        $this->hash = $hash;
    }

    /**
     * Returns the string for the new block hash
     * @return string
     */
    public function getHashableString()
    {
        return $this->getIndex() . $this->getPreviousHash() . $this->getTimestamp() . $this->getData();
    }

    /**
     * Return the index of the block
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Returns the previous blocks hash
     * @return string
     */
    public function getPreviousHash()
    {
        return $this->previousHash;
    }

    /**
     * Return the timestamp of the block
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Return the data of the block
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Return the hash of the block
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
}
