<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Repository\ConfigRepository;

class EmailDomainValidator extends ConstraintValidator
{   
    /**
     * @var ConfigRepository
     */
    private  $configRepository;
    private  $globalBlocked = [];

    public function __construct(ConfigRepository $configRepository, $globalBlockedDomains = '')
    {
        $this->globalBlocked = explode(',', $globalBlockedDomains);
        $this->configRepository = $configRepository;
    }
    public function validate($value, Constraint $constraint)
    {
         /* @var $constraint \App\Validator\EmailDomain */
        if (null === $value || '' === $value) {
            return;
        }

        $domain = substr($value,strpos($value,'@') + 1);
        $BlockedDomain = array_merge($constraint->blocked,$this->configRepository->
        getAsArray('blockedDomains',$this->globalBlocked));
        if(in_array($domain,$BlockedDomain)){
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
        }
        // TODO: implement the validation here
     
    }
}
