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
        $this->chain->createNewBlock('my new block!');

        $this->assertCount(2, $this->chain->getBlocks());
    }

    /** @test */
    public function itCanGetABlock()
    {
        $this->chain->createNewBlock('my new block!');

        $this->assertNotNull($this->chain->getBlock(1));
    }

    /** @test */
    public function itCanValidateTheChain()
    {
        $this->chain->createNewBlock('my new block!');
        $this->chain->createNewBlock('my new new block!');
        $this->chain->createNewBlock('my newest block!');

        $this->assertTrue($this->chain->checkValidity());
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
}
