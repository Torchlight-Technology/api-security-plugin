<?php

namespace App\Provider;

use Aws\Credentials\CredentialProvider;
use Aws\Credentials\AssumeRoleCredentialProvider;
use Aws\Sts\StsClient;

class AssumeRole {

    public static function getProvider() {

        $stsClient = new StsClient([
            'version' => 'latest',
            'region' => 'us-east-1'
        ]);

        $assumeRoleCredentials = new AssumeRoleCredentialProvider([
            'client' => $stsClient,
            'assume_role_params' => [
                'RoleArn' => env('ASSUME_ROLE_ARN'),
                'RoleSessionName' => "assume-role-session",
            ],
        ]);

        // To avoid unnecessarily fetching STS credentials on every API operation,
        // the memoize function handles automatically refreshing the credentials when they expire
        $provider = CredentialProvider::memoize($assumeRoleCredentials);

        return $provider;
    }

}
