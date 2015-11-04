<?php
/**
 * Created by PhpStorm.
 * User: fierk007
 * Date: 11/4/2015
 * Time: 1:54 PM
 */

namespace UMRA\Bundle\MemberBundle\Handlers;

use Doctrine\Common\Persistence\ObjectManager;
use Rhumsaa\Uuid\Uuid;
use Symfony\Component\Form\FormInterface;

class MembershipTransactionBuilder
{
    private $em;

    /**
     * MembershipTransactionBuilder constructor.
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormInterface $form
     * @param string $type
     * @return array
     */
    public function buildOptions(FormInterface $form, $type = null) {
        $formData = $form->getData();

        $pmtMethod = $form->get('payCreditCard')->isClicked()
            ? "CREDIT_CARD"
            : "CHECK";
        $membershipCost = $formData['membershipType'];
        $membershipStatus = $formData['membershipStatus'] === "new"
            ? "MEMBERSHIP_NEW"
            : "MEMBERSHIP_RENEW";
        $isLuncheonPreorder = $formData["luncheonPreorder"] !== "none";
        $couponCount = (int) $formData["parkingCoupon"];

        if ($formData["luncheonPreorder"] === "single") {
            $luncheonPeopleCount = 1;
        } elseif ($formData["luncheonPreorder"] === "couple") {
            $luncheonPeopleCount = 2;
        } else {
            $luncheonPeopleCount = 0;
        }

        $invoiceId = Uuid::uuid1()->toString();

        $transOptions = array(
            "pmtMethod" => $pmtMethod,
            "membership" => array(
                "cost" => $membershipCost,
                "type" => $type != null ? $type : $membershipStatus
            ),
            "luncheons" => array(
                "isPreorder" => $isLuncheonPreorder,
                "attendeeCount" => $luncheonPeopleCount
            ),
            "couponCount" => $couponCount,
            "invoiceId" => $invoiceId
        );

        return $transOptions;
    }
    /**
     * @param Person $member
     * @param array $options
     */
    public function build(Person $member, array $options) {
        // TODO: Validate $options

        $transactions = array();

        $pmtMethod = $options["pmtMethod"];
        $membershipType = $options["membership"]["type"];
        $membershipCost = (float) $options["membership"]["cost"];
        $isLuncheonPreorder = (bool) $options["luncheons"]["isPreorder"];
        $attendeeCount = (int) $options["luncheons"]["attendeeCount"];
        $couponCount = (int) $options["couponCount"];
        $invoiceId = $options["invoiceId"];

        // Create transaction for membership fee.
        $membershipTrans = new Trans();
        $membershipTrans->setPerson($member)
            ->setTrantype($membershipType)
            ->setTrandate(new \DateTime("now"))
            ->setStatus("AWAITING_PROCESS")
            ->setPmtmethod($pmtMethod)
            ->setAmount($membershipCost)
            ->setInvoiceId($invoiceId)
        ;
        $this->em->persist($membershipTrans);
        $transactions[] = $membershipTrans;

        if ($isLuncheonPreorder) {
            $luncheons = $this->em->getRepository('UMRAMemberBundle:Luncheon')
                ->findLatestLuncheons(7, true, new \DateTime("now"));

            // Create transactions for luncheons
            foreach ($luncheons as $luncheon) {
                $trans = new Trans();
                $trans->setPerson($member)
                    ->setTrantype("LUNCHEON_FEE")
                    ->setTrandate(new \DateTime("now"))
                    ->setStatus("AWAITING_PROCESS")
                    ->setPmtmethod($pmtMethod)
                    ->setAmount($luncheon->getPrice() * $attendeeCount)
                    ->setLuncheon($luncheon)
                    ->setNotes("$attendeeCount attendees")
                    ->setInvoiceId($invoiceId)
                ;
                $this->em->persist($trans);

                $transactions[] = $trans;
            }
        }

        if ($couponCount > 0) {
            $couponTrans = new Trans();
            $couponTrans->setPerson($member)
                ->setTrantype("PARKING_PASS")
                ->setTrandate(new \DateTime("now"))
                ->setStatus("AWAITING_PROCESS")
                ->setPmtmethod("OTHER")
                ->setAmount(0)
                ->setNotes("$couponCount free parking coupons")
                ->setInvoiceId($invoiceId)
            ;
            $this->em->persist($couponTrans);

            $transactions[] = $couponTrans;
        }

        $this->em->flush();

        return $transactions;
    }
}