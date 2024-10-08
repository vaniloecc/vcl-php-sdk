<?php

declare(strict_types=1);

namespace VaniloCloud\WriteModels;

use VaniloCloud\Enums\FulfillmentStatus;
use VaniloCloud\Enums\OrderStatus;

class OrderCreate extends BaseWriteModel
{
    public function setBillpayer(BillpayerWrite $billpayerWrite): self
    {
        $this->data['billpayer'] = $billpayerWrite->toArray();

        return $this;
    }

    public function setShippingAddress(AddressWrite $addressWrite): self
    {
        $this->data['shipping_address'] = $addressWrite->toArray();

        return $this;
    }

    /**
     * @var OrderItemWrite[] $orderItemWrites
     */
    public function setItems(OrderItemWrite ...$orderItemWrites): self
    {
        $this->data['items'] = array_map(
            static fn ($item) => $item->toArray(),
            $orderItemWrites
        );

        return $this;
    }

    public function setStatus(?OrderStatus $status): self
    {
        $this->data['status'] = $status;

        return $this;
    }

    public function setFulfillmentStatus(?FulfillmentStatus $fulfillmentStatus): self
    {
        $this->data['fulfillment_status'] = $fulfillmentStatus;

        return $this;
    }

    public function setUserId(?string $userId): self
    {
        $this->data['user_id'] = $userId;

        return $this;
    }

    public function setShippingMethodId(?string $shippingMethodId): self
    {
        $this->data['shipping_method_id'] = $shippingMethodId;

        return $this;
    }

    public function setChannel(?string $channel): self
    {
        $this->data['channel'] = $channel;

        return $this;
    }

    public function setChannelId(?string $channelId): self
    {
        $this->data['channel_id'] = $channelId;

        return $this;
    }

    public function setLanguage(?string $language): self
    {
        $this->data['language'] = $language;

        return $this;
    }

    public function setCurrency(?string $currency): self
    {
        $this->data['currency'] = $currency;

        return $this;
    }

    public function setOrderedAt(?string $orderedAt): self
    {
        $this->data['ordered_at'] = $orderedAt;

        return $this;
    }

    public function setNumber(?string $number): self
    {
        $this->data['number'] = $number;

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

    public function setNotes(?string $notes): self
    {
        $this->data['notes'] = $notes;

        return $this;
    }

    public function setInstructions(array $instructions): self
    {
        $this->data['__instructions'] = $instructions;

        return $this;
    }
}
