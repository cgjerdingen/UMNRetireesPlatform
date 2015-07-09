<?php
namespace UMRA\Bundle\MemberBundle\Services;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PayPalApiContextService
{
    public static function getApiContext($config)
    {
        $apiContext = new ApiContext(new OAuthTokenCredential(
            $config['client_id'],
            $config['client_secret']
        ));

        $apiContext->setConfig(array(
            'http.ConnectionTimeOut' => 30,
            'http.Retry' => 1,
            'mode' => $config['environment'],
            'log.LogEnabled' => false,
            'log.FileName' => '../PayPal.log',
            'log.LogLevel' => 'INFO'
        ));

        return $apiContext;
    }
}
