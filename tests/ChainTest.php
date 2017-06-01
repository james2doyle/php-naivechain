<?php

namespace Blockchain\Naivechain;

use \PHPUnit\Framework\TestCase;

use Blockchain\Naivechain\Exceptions\InvalidBlockIndexException;
use Blockchain\Naivechain\Exceptions\InvalidBlockHashException;

class ChainTest extends TestCase
{
    public $chain;

    public function setUp()
    {
        parent::setUp();

        $this->chain = new Chain(new GenesisBlock());
    }

    /** @test */
    public function itCanCreateANewChain()
    {
        $this->assertCount(1, $this->chain->getBlocks());
    }

    /** @test */
    public function itCanGetTheLatestBlock()
    {
        $this->assertEquals($this->chain->getBlock(0), $this->chain->getLatestBlock());
    }

    /** @test */
    public function itCanCreateANewBlock()
    {
        $new_block = $this->chain->createNewBlock('my new block!');

        $this->assertCount(2, $this->chain->getBlocks());
        $this->assertEquals($new_block->getHash(), $this->chain->getLatestBlock()->getHash());
    }

    /** @test */
    public function itCanGetABlock()
    {
        $new_block = $this->chain->createNewBlock('my new block!');

        $this->assertNotNull($this->chain->getBlock(1));
        $this->assertEquals($new_block->getHash(), $this->chain->getBlock(1)->getHash());
    }

    /** @test */
    public function itCanNoticeBadBlocks()
    {
        $this->expectException(InvalidBlockHashException::class);

        $this->chain->createNewBlock('my new block!');

        $badBlock = new Block(2, '0', time(), 'my genesis block!!', '816534932c2b7154836da6afc367695e6337db8a921823784c14378abed4f7d7');

        $this->chain->addBlock($badBlock);

        $this->assertTrue($this->chain->checkValidity());
    }

    /** @test */
    public function itCanErrorWhenAnInvalidBlockIsAdded()
    {
        $this->expectException(InvalidBlockIndexException::class);

        $this->chain->createNewBlock('my new block!');
        $this->chain->createNewBlock('my new new block!');
        $this->chain->addBlock($this->chain->getBlock(1));

        $this->assertTrue($this->chain->checkValidity());
    }

    /** @test */
    public function itCanValidateTheChain()
    {
        $block_1 = $this->chain->createNewBlock('my new block!');
        $block_2 = $this->chain->createNewBlock('my new new block!');
        $block_3 = $this->chain->createNewBlock('my newest block!');

        // chain is good
        $this->assertTrue($this->chain->checkValidity());

        // hashes are not the same
        $this->assertNotEquals($this->chain->getBlock(0)->getHash(), $block_1->getHash());
        $this->assertNotEquals($block_2->getHash(), $block_1->getHash());
        $this->assertNotEquals($block_3->getHash(), $block_2->getHash());

        // hashes match the origin
        $this->assertEquals($block_1->getPreviousHash(), $this->chain->getBlock(0)->getHash());
        $this->assertEquals($block_2->getPreviousHash(), $block_1->getHash());
        $this->assertEquals($block_3->getPreviousHash(), $block_2->getHash());
    }
}
