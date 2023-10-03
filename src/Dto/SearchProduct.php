<?php
/**
 * @author BEN KACHOUD Hicham <h.benkachoud.im@gmail.com>
 */

namespace App\Dto;

use App\Entity\Category;

class SearchProduct
{
    /** @var null | string  */
    public ?string $keyWord = '';
    /** @var null | Category[]  */
    public ?array $categories = [];
}