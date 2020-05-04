<?php
declare(strict_types = 1);

namespace Learning\AdditionalDescription\Controller\Index;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action implements HttpGetActionInterface
{
    private $customerRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    public function __construct(
        Context $context,
        CustomerRepositoryInterface $repository,
        SearchCriteriaBuilder $criteriaBuilder
    ) {
        $this->customerRepository = $repository;
        $this->searchCriteriaBuilder = $criteriaBuilder;
        parent::__construct($context);
    }
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
//        $criteria = $this->searchCriteriaBuilder->create();
//        $customer = $this->customerRepository->getById(2);
        $customer = $this->customerRepository->getById(2);
        var_dump($this->customerRepository->get($customer->getEmail())->getExtensionAttributes());
//        $customers = $this->customerRepository->getList($criteria)->getItems();
//        foreach ($customers as $customer) {
//            $ext = $customer->getExtensionAttributes();
//            echo $customer->getEmail();
//            echo '<br/>';
//        }
        die();
        return $result;
    }
}
