<?php

namespace jewellclub\task;

use jewellclub\common\BaseComponent;

/**
 * Базовый класс для задач
 */
abstract class BaseTask extends BaseComponent
{
    /**
     * Запустить задачу
     * @return void
     */
    public abstract function run(): void;

    /**
     * Результат работы задачи
     * @return mixed|null
     */
    public abstract function getResultRaw();
}