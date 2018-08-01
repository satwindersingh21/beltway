<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ArticleLikesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ArticleLikesTable Test Case
 */
class ArticleLikesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ArticleLikesTable
     */
    public $ArticleLikes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.article_likes',
        'app.articles',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ArticleLikes') ? [] : ['className' => ArticleLikesTable::class];
        $this->ArticleLikes = TableRegistry::getTableLocator()->get('ArticleLikes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ArticleLikes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
