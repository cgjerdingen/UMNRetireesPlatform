<?php
namespace UMRA\Bundle\MemberBundle\Services;

use PayPal\Api\Item;
use PayPal\Api\NameValuePair;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PayPalApiService
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

    public static function getItemsFromTransactions($transactions, $couponCount, $luncheonPeopleCount)
    {
        $items = array();

        foreach ($transactions as $trans)
        {
            $transType = $trans->getTranType();
            $item = new Item();

            // Add transaction ID to postback data collection
            $nvp = new NameValuePair();
            $nvp->setName("transactionId");
            $nvp->setValue($trans->getId());

            if ($transType === "MEMBERSHIP_NEW" ||
                $transType === "MEMBERSHIP_RENEW")
            {
                $item->setName('UMRA Membership - 1 Year')
                     ->setCurrency('USD')
                     ->setQuantity(1)
                     ->setPrice((float) $trans->getAmount())
                     ->addPostbackData($nvp);
                ;
            }
            elseif ($transType === "LUNCHEON_FEE")
            {
                $luncheon = $trans->getLuncheon();

                $item->setName((string) $luncheon)
                     ->setCurrency('USD')
                     ->setQuantity($luncheonPeopleCount)
                     ->setPrice((float) $luncheon->getPrice())
                     ->addPostbackData($nvp);
                ;
            }
            else
            {
                if ($couponCount > 0)
                {
                    // Coupons are processed seperately, so no need for postback data
                    $item->setName('Free Parking Coupons')
                         ->setCurrency('USD')
                         ->setQuantity($couponCount)
                         ->setPrice(0)
                    ;
                }
            }

            $items[] = $item;
        }

        return $items;
    }

    public static function generateInvoiceId($transactions)
    {
        $tranIds = array();

        foreach($transactions as $trans)
        {
            $tranIds[] = $trans->getId();
        }

        $preEncodedId = implode(";", $tranIds);

        return base64_encode($preEncodedId);
    }

    public static function getIdsFromTransaction($transaction)
    {

        var_dump($transaction->getInvoiceNumber());
        $transIdsStr = base64_decode($transaction->getInvoiceNumber());
        $transIds = explode(";", $transIdsStr);

        return $transIds;
    }
}
