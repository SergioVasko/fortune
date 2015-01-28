<?php
// File: src/Fortune/ApplicationBundle/Tests/Entity/QuoteRepositoryTest.php

namespace Fortune\ApplicationBundle\Tests\Entity;

use Fortune\ApplicationBundle\Entity\Quote;
use Fortune\ApplicationBundle\Entity\QuoteFactory;
use Fortune\ApplicationBundle\Entity\QuoteGateway;
use Fortune\ApplicationBundle\Entity\QuoteRepository;
use Prophecy\PhpUnit\ProphecyTestCase;

class QuoteRepositoryTest extends ProphecyTestCase
{
    const ID = 42;
    const CONTENT = '<KnightOfNi> Ni!';

    private $gateway;
    private $repository;

    public function setUp()
    {
        /*
        //$filename = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'fortune_database_test.txt';
        $filename = 'D:\webservers\home\symfony\gnugat\fortune\src\Fortune\ApplicationBundle\Tests\fortune_database_test.txt';
        $gateway = new QuoteGateway($filename);
        $this->repository = new QuoteRepository($gateway, $factory);
        */

        parent::setUp();
        $gatewayClassname = 'Fortune\ApplicationBundle\Entity\QuoteGateway';
        $this->gateway = $this->prophesize($gatewayClassname);
        $factory = new QuoteFactory();
        $this->repository = new QuoteRepository($this->gateway->reveal(), $factory);
    }

    public function testItPersistsTheQuote()
    {
        /*
        $quote = $this->repository->insert(self::CONTENT);
        $id = $quote['quote']['id'];
        $quotes = $this->repository->findAll();
        $foundQuote = $quotes['quotes'][$id];

        $this->assertSame(self::CONTENT, $foundQuote['content']);
        */
        $quote = new Quote(self::ID, self::CONTENT);
        $this->gateway->insert(self::CONTENT)->willReturn($quote);
        $this->repository->insert(self::CONTENT);

        $this->gateway->findAll()->willReturn(array($quote));
        $quotes = $this->repository->findAll();
        $foundQuote = $quotes['quotes'][self::ID];

        $this->assertSame(self::CONTENT, $foundQuote['content']);
    }
}
