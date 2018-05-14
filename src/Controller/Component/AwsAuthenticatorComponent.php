<?php
namespace ApiGateway\Controller\Component;

use Cake\Cache\Cache;
use Cake\Controller\Component;
use Cake\Controller\Exception\AuthSecurityException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

use Aws\ApiGateway\ApiGatewayClient;

class AwsAuthenticatorComponent extends Component
{
    public function beforeFilter(Event $event) {
        // Check to see if requested endpoint is one under ApiGateway control
        $request = $event->getSubject()->request;
        //debug($request->getParam('controller'));
        //debug($request->getParam('action'));
        $controller = $request->getParam('controller');
        $method = $request->getParam('action');

        $endPointsTable = TableRegistry::get('ApiGateway.EndPoints');

        $isProtected = $endPointsTable->isMethodProtected($controller, $method);

        if($isProtected) {
            // Check AWS keys
            $apiKey = $request->getHeader('x-api-key');

            $authorized = false;

            if(!empty($apiKey)) {
                //debug($apiKey);
                $clientApiKey = $apiKey[0];

                $results = Cache::read('aws', 'api-keys');

                if(!$results) {
                    $apiGateway = new ApiGatewayClient([
                        'region' => 'us-east-1',
                        'version' => 'latest',
                        'credentials' => [
                            'key' => env('AWS_ACCESS_KEY_ID'),
                            'secret' => env('AWS_SECRET_ACCESS_KEY')
                        ]
                    ]);
                    $results = $apiGateway->getApiKeys(['includeValues' => true]);

                    $results = $results['items'];
                    Cache::write('aws', $results, 'api-keys');
                }
                //debug($results);
                foreach($results as $awsApiKey) {
                    if($awsApiKey['value'] == $clientApiKey) {
                        $authorized = true;
                        break;
                    }
                }
            }


            if(!$authorized) {
                throw new AuthSecurityException('No way dude. Not Authorized');
            }
        }

    }
}