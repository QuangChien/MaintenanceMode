<?php
/**
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\MaintenanceMode\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\MaintenanceMode;

class CheckMaintenanceMode implements ObserverInterface
{
    /**
     * @var RequestInterface
     */
    public $request;

    /**
     * @var MaintenanceMode
     */
    public $maintenanceMode;

    public function __construct(
        RequestInterface $request,
        MaintenanceMode $maintenanceMode
    )
    {
        $this->request = $request;
        $this->maintenanceMode = $maintenanceMode;
    }

    public function execute(EventObserver $observer)
    {
        $data = $this->request->getParam('groups');
        $enable = $data['general']['fields']['enable']['value'];
        $allowIps = $data['general']['fields']['allow_ips']['value'];
        if($enable === false) {
            $allowIps = '';
        }
        $this->maintenanceMode->setAddresses($allowIps);
        $this->maintenanceMode->set($enable);
    }
}
?>
