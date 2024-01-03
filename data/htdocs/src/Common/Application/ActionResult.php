<?php

namespace Common\Application;

abstract class ActionResult
{
    private $success = false;

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     * @return ActionResult
     */
    public function setSuccess(bool $success): ActionResult
    {
        $this->success = $success;
        return $this;
    }


}