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
        $controller = $request->getParam('controller');
        $method = $request->getParam('action');

        $endPointsTable = TableRegistry::get('ApiGateway.EndPoints');

        $isProtected = $endPointsTable->isMethodProtected($controller, $method);

        if($isProtected) {
            // Check AWS keys
            $apiKey = $request->getHeader('x-api-key');

            $authorized = false;

            if(!empty($apiKey)) {
                $clientApiKey = $apiKey[0];

                $keys = Cache::read('aws', 'api-keys');

                if(!$keys) {
                    $apiGateway = new ApiGatewayClient([
                        'region' => 'us-east-1',
                        'version' => 'latest',
                        'credentials' => [
                            'key' => env('AWS_ACCESS_KEY_ID'),
                            'secret' => env('AWS_SECRET_ACCESS_KEY')
                        ]
                    ]);

                    // getPaginator auto paginates through the results
                    // https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_paginators.html
                    $results = $apiGateway->getPaginator('GetApiKeys', [
                        'includeValues' => true
                    ]);

                    // store the paginated results in keys
                    $keys = [];
                    foreach ($results as $result) {
                        $keys[] = $result['items'];
                    }

                    // flatten 'er up
                    $keys = array_merge(...$keys);
                    // write them to cache
                    Cache::write('aws', $keys, 'api-keys');
                }
                //debug($keys);
                foreach($keys as $awsApiKey) {
                    if($awsApiKey['enabled'] === true && $awsApiKey['value'] == $clientApiKey) {
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