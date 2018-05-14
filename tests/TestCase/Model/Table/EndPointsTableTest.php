<?php
namespace ApiGateway\Test\TestCase\Model\Table;

use ApiGateway\Model\Table\EndPointsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * ApiGateway\Model\Table\EndPointsTable Test Case
 */
class EndPointsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \ApiGateway\Model\Table\EndPointsTable
     */
    public $EndPoints;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api_gateway.end_points'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('EndPoints') ? [] : ['className' => EndPointsTable::class];
        $this->EndPoints = TableRegistry::get('EndPoints', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EndPoints);

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
}
