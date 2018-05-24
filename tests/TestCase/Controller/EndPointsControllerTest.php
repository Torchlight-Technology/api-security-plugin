<?php
namespace ApiGateway\Test\TestCase\Controller;

use ApiGateway\Controller\EndPointsController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\Log\Log;

/**
 * ApiGateway\Controller\EndPointsController Test Case
 */
class EndPointsControllerTest extends IntegrationTestCase
{

    public function testIndex()
    {
        $this->disableErrorHandlerMiddleware();
        $this->get('/api-gateway/end-points');
        Log::debug($this->_response->getBody());
        $this->assertResponseOk();
    }
}
