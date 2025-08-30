<?php
/**
 * Метод описывает DTO объект z-отчета
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use DateTime;

/**
 * Class ZReports
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class ZReports
{
    /**
     * @var DateTime время z-отчета
     */
    protected $timeStampUts;
    /**
     * @var int фискальный номер смещения
     */
    protected $fiscalShiftNum;
    /**
     * @var int номер документа
     */
    protected $fiscalDocNum;

    /**
     * ZReports constructor.
     *
     * @param DateTime $timeStampUts
     * @param int       $fiscalShiftNum
     * @param int       $fiscalDocNum
     */
    public function __construct(DateTime $timeStampUts, int $fiscalShiftNum, int $fiscalDocNum)
    {
        $this->setTimeStampUts($timeStampUts);
        $this->setFiscalShiftNum($fiscalShiftNum);
        $this->setFiscalDocNum($fiscalDocNum);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'timestamp_uts'    => $this->getTimeStampUts(),
            'fiscal_shift_num' => $this->getFiscalShiftNum(),
            'fiscal_doc_num'   => $this->getFiscalDocNum()
        ];
    }

    /**
     * @return DateTime
     */
    public function getTimeStampUts(): DateTime
    {
        return $this->timeStampUts;
    }

    /**
     * @param DateTime $timeStampUts
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\ZReports
     */
    public function setTimeStampUts(DateTime $timeStampUts): ZReports
    {
        $this->timeStampUts = $timeStampUts;
        return $this;
    }

    /**
     * @return int
     */
    public function getFiscalShiftNum(): int
    {
        return $this->fiscalShiftNum;
    }

    /**
     * @param int $fiscalShiftNum
     *
     * @return ZReports
     */
    public function setFiscalShiftNum(int $fiscalShiftNum): ZReports
    {
        $this->fiscalShiftNum = $fiscalShiftNum;
        return $this;
    }

    /**
     * @return int
     */
    public function getFiscalDocNum(): int
    {
        return $this->fiscalDocNum;
    }

    /**
     * @param int $fiscalDocNum
     *
     * @return ZReports
     */
    public function setFiscalDocNum(int $fiscalDocNum): ZReports
    {
        $this->fiscalDocNum = $fiscalDocNum;
        return $this;
    }
}
