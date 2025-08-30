<?php
/**
 * Класс описывает коллекцию DTO объектов ZReports (z-отчетов)
 */
declare(strict_types = 1);

namespace Rarus\Online\Kkt\Queue\DTO;

use SplObjectStorage;

/**
 * Class ProductCollection
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 * @method  attach(ZReports $object, $data = null)
 */
class ZReportCollection extends SplObjectStorage
{
}
