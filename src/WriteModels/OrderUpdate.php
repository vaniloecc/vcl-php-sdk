<?php

declare(strict_types=1);

namespace VaniloCloud\WriteModels;

use VaniloCloud\Enums\FulfillmentStatus;
use VaniloCloud\Enums\OrderStatus;

class OrderUpdate extends BaseWriteModel
{
    public function setStatus(OrderStatus $status): self
    {
        $this->data['status'] = $status;

        return $this;
    }

    public function setFulfillmentStatus(?FulfillmentStatus $fulfillmentStatus): self
    {
        $this->data['fulfillment_status'] = $fulfillmentStatus;

        return $this;
    }

    public function setShippingMethodId(?string $shippingMethodId): self
    {
        $this->data['shipping_method_id'] = $shippingMethodId;

        return $this;
    }

    public function setLanguage(?string $language): self
    {
        $this->data['language'] = $language;

        return $this;
    }

    public function setPayableRemoteId(?string $payableRemoteId): self
    {
        $this->data['payable_remote_id'] = $payableRemoteId;

        return $this;
    }

    public function setReseller(?string $reseller): self
    {
        $this->data['reseller'] = $reseller;

        return $this;
    }

    public function setAffiliate(?string $affiliate): self
    {
        $this->data['affiliate'] = $affiliate;

        return $this;
    }
}
