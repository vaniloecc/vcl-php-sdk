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

    public function setFulfillmentStatus(?FulfillmentStatus $fulfillment_status): self
    {
        $this->data['fulfillment_status'] = $fulfillment_status;

        return $this;
    }

    public function setShippingMethodId(?string $shipping_method_id): self
    {
        $this->data['shipping_method_id'] = $shipping_method_id;

        return $this;
    }

    public function setLanguage(?string $language): self
    {
        $this->data['language'] = $language;

        return $this;
    }

    public function setPayableRemoteId(?string $payable_remote_id): self
    {
        $this->data['payable_remote_id'] = $payable_remote_id;

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
