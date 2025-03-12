<?php
/**
 * Класс описывает коллекцию DTO объектов Product (товаров в чеке)
 */
declare(strict_types = 1);

namespace Rarus\Online\Kkt\Queue\DTO;

use SplObjectStorage;

/**
 * Class ProductCollection
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 * @method  attach(Product $object, $data = null)
 */
class ProductCollection extends SplObjectStorage
{
}
