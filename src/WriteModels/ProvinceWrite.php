<?php

declare(strict_types=1);

namespace VaniloCloud\WriteModels;

class ProvinceWrite extends BaseWriteModel
{
    public function setCode(?string $code): self
    {
        $this->data['code'] = $code;

        return $this;
    }

    public function setName(?string $name): self
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function setType(?string $type): self
    {
        $this->data['type'] = $type;

        return $this;
    }
}
