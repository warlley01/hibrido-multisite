<?php

namespace Hibrido\MultiSite\Block;

use Magento\Cms\Model\Page;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class AboutUsMultipleStoresIdentifier extends \Magento\Framework\View\Element\Template
{
    protected $cmsPage;
    protected $storeManager;
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        Page $cmsPage,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig
    )
    {
        parent::__construct($context);
        $this->cmsPage = $cmsPage;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    public function isMultipleStore()
    {
        $pageIdentifier = $this->getPageIdentifier();
        $stores = $this->getStores();

        $storeUseCmsPage = [];
        foreach ($stores as $store) {
            $cmsPageId = $this->cmsPage->checkIdentifier($pageIdentifier, $store->getId());
            if($cmsPageId) {
                array_push($storeUseCmsPage, ['store_id' => $store->getId()]); // ignore default?
            }
        }

        return (sizeof($storeUseCmsPage) > 1) ? true : false;
    }

    public function getStores()
    {
        return $this->storeManager->getStores();
    }

    public function getPageIdentifier()
    {
        return $this->cmsPage->getIdentifier();
    }

    public function getStoreLanguage()
    {
        $currentStoreId = $this->storeManager->getStore()->getId();
        $storeLanguage = $this->scopeConfig->getValue('general/locale/code', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $currentStoreId);

        return str_replace('_', '-', strtolower($storeLanguage));
    }

    public function getStoreBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl();
    }
}
