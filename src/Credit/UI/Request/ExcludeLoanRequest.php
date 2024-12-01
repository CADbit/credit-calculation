<?php

declare(strict_types=1);

namespace App\Credit\UI\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class ExcludeLoanRequest
{
    #[Assert\Type("string")]
    #[Assert\Length(min: 36, max: 36)]
    public string $hid;

    public function __construct(string $hid)
    {
        $this->hid = $hid;

    }
}
