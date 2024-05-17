<?php

namespace app\models;

use Yii;
use yii\base\Model;

class BankStatementForm extends Model
{
    public $start_time;
    public $end_time;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time'], 'required'],
            [['start_time', 'end_time'], 'string'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'start_time' => 'Начальная дата',
            'end_time' => 'Конечная дата',
        ];
    }
}
