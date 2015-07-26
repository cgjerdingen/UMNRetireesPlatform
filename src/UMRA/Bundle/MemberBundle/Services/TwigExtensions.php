<?php
namespace UMRA\Bundle\MemberBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use UMRA\Bundle\MemberBundle\Entity\ContentBlock;

class TwigExtensions extends \Twig_Extension
{
    private $em;
    private $logger;

    public function __construct(ObjectManager $em, $logger) {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function umraContent($contentName) {
        $contentRepo = $this->em->getRepository('UMRAMemberBundle:ContentBlock');

        $contentBlock = $contentRepo->findOneBy(array('name' => $contentName));

        if (!$contentBlock instanceof ContentBlock) {
            $this->logger->warn("ContentBlock with name ".$contentName." not found!");
            return "";
        }

        return $contentBlock->getContent();
    }

    public function getFunctions() {
        return array(
            'umra_content' => new \Twig_Function_Method($this, 'umraContent', array(
                 'is_safe' => array('html')
             ))
        );
    }

    public function getName() {
        return "umra_twig_extension";
    }
}
