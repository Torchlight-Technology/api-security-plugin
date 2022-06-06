<?php
namespace ApiGateway\Test\TestCase\Controller;

use ApiGateway\Controller\EndPointsController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\Log\Log;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * ApiGateway\Controller\EndPointsController Test Case
 */
class EndPointsControllerTest
{

    use IntegrationTestTrait;

    public function testIndex()
    {
        $this->disableErrorHandlerMiddleware();
        $this->get('/api-gateway/end-points');
        Log::debug($this->_response->getBody());
        $this->assertResponseOk();
    }
}
