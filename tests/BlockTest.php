<?php

namespace Blockchain\Naivechain;

use \PHPUnit\Framework\TestCase;

class BlockTest extends TestCase
{
    /** @test */
    public function itCanCreateTheGenesisBlock()
    {
        $block = new GenesisBlock();

        $this->assertEquals('0', $block->getPreviousHash());
        $this->assertEquals('816534932c2b7154836da6afc367695e6337db8a921823784c14378abed4f7d7', $block->getHash());
    }

    /** @test */
    public function itCanCreateABlock()
    {
        $block = new Block(0, '0', time(), 'my genesis block!!', '816534932c2b7154836da6afc367695e6337db8a921823784c14378abed4f7d7');

        $this->assertEquals('0', $block->getPreviousHash());
        $this->assertEquals('816534932c2b7154836da6afc367695e6337db8a921823784c14378abed4f7d7', $block->getHash());
    }

    /** @test */
    public function itCanCreateANewChildBlock()
    {
        $block = new GenesisBlock();
        $new_block = $block->generateChild('my new block!');

        $this->assertEquals(1, $new_block->getIndex());
        $this->assertEquals($block->getHash(), $new_block->getPreviousHash());
        $this->assertNotEquals($block->getIndex(), $new_block->getIndex());
    }
}
