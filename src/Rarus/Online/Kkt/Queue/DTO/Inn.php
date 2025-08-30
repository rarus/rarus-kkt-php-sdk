<?php
/**
 * Структура описывает ИНН
 */
declare(strict_types=1);

namespace Rarus\Online\Kkt\Queue\DTO;

use Money\Money;
use Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgentInfoType;
use Rarus\Online\Kkt\Queue\DTO\AgentInfoPaymentAgentInfoTypeValue;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumber;

/**
 * Class Inn
 *
 * @package Rarus\Online\Kkt\Queue\DTO
 */
class Inn
{
    /**
     * @var string ИНН
     */
    protected $inn;

    /**
     * Inn constructor.
     *
     * @param $inn
     */
    public function __construct(
        ?string $inn
    ) {
        $this->setInn($inn);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [    
            'inn' => $this->getInn()         
        ];
    }

    /**
     * @return string
     */
    public function getInn()
    {
        return $this->inn;
    }

    /**
     * @param $inn
     *
     * @return \Rarus\Online\Kkt\Queue\DTO\Inn
     */
    protected function setInn($inn): inn
    {
    	if(!empty($inn) && is_numeric($inn)) {
        	$this->inn = $inn;
    	} else {
    		$this->inn = '';
    	}
        return $this;
    }
}
