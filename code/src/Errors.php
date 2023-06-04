<?php

namespace Ayagudin\BrackersValid;

/**
 *Список ошибок
 */
class Errors
{
    const EMPTY_STRING = "Пустая строка или строка без скобок";
    const BRACKET_COUNT_ERROR = "Количество открывающихся и закрывающихся скобок не соответствует- все плохо";
    const BRACKET_COUNT_DIFF_ERROR = "Конструкция ')('- не допустима";
    const BRACKET_COUNT_SUCCESS = "Количество скобок - валидно!";
}