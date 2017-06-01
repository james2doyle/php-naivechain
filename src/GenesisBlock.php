<?php

namespace Blockchain\Naivechain;

use Blockchain\Naivechain\Block;

class GenesisBlock extends Block
{
    /**
     * Create a genesis block
     * @return Block
     */
    public function __construct()
    {
        // just some random details for the first block
        return parent::__construct(0, '0', 1465154705, 'my genesis block!!', '816534932c2b7154836da6afc367695e6337db8a921823784c14378abed4f7d7');
    }
}
