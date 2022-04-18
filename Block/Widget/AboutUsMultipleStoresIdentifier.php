<?php
namespace Hibrido\MultiSite\Block\Widget;

use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Cms\Model\Page;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Framework\Locale\Resolver;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Widget\Block\BlockInterface;

class AboutUsMultipleStoresIdentifier extends \Magento\Framework\View\Element\Template implements BlockInterface
{
    protected $cmsPage;
    protected $storeRepository;
    protected $storeDataInterface;
    protected $localeResolver;
    protected $storeManager;
    protected $scopeConfig;
    protected $_template = "widget/aboutUs.phtml";

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        Page $cmsPage,
        StoreRepositoryInterface $storeRepository,
        StoreInterface $storeDataInterface,
        Resolver $localeResolver,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig
    )
    {
        parent::__construct($context);
        $this->cmsPage = $cmsPage;
        $this->storeRepository = $storeRepository;
        $this->storeDataInterface = $storeDataInterface;
        $this->localeResolver = $localeResolver;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    public function isMultipleStore()
    {
        $pageIdentifier = $this->getPageIdentifier();
        $this->cmsPage->getId();

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

   /* public function getStoreData()
    {
        $stores = $this->getStores();

        $storesData = [];
        foreach($stores as $store) {
            $currentStore = [];
            $currentStore['store_id'] = $store->getId();
            $currentStore['language'] = $this->scopeConfig->getValue('general/locale/code', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store->getStoreId());
            $currentStore['base_url'] = $store->getBaseUrl();
            $currentStore['cms_page_url'] = $pageIdentifier = $this->getPageIdentifier(); // deve ser diferente para cada linguagem
            array_push($storesData, $currentStore);
        }

        return $storesData;
    } */

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

    public function getCmsPageIdentifier()
    {
        return $this->getPageIdentifier();
    }
}
