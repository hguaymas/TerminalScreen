<?php
namespace Terminal\AdminBundle\Doctrine\DBAL\Types;

class EnumDiasSemanaType extends EnumType
{
    protected $name = 'enum_dias_semana';
    protected $values = array('lun', 'mar', 'mie', 'jue', 'vie', 'sab', 'dom');
}