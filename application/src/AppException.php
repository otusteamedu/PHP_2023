<?php

declare(strict_types=1);

namespace Gesparo\HW;

class AppException extends \Exception
{
    private const CANNOT_SET_FETCH_MODE_IN_SELECT = 1;
    private const EXECUTE_SELECT_FAILED = 2;
    private const EXECUTE_INSERT_FAILED = 3;
    private const EXECUTE_UPDATE_FAILED = 4;
    private const EXECUTE_DELETE_FAILED = 5;
    private const EXECUTE_SELECT_MANY_FAILED = 6;

    public static function cannotSetFetchModeInSelect(): self
    {
        return new self('Cannot set fetch mode in select', self::CANNOT_SET_FETCH_MODE_IN_SELECT);
    }

    public static function executeSelectFailed(int $id): self
    {
        return new self("Execute select failed for getting data by id '$id'", self::EXECUTE_SELECT_FAILED);
    }

    /**
     * @throws \JsonException
     */
    public static function executeInsertFailed(array $data): self
    {
        $stringData = json_encode($data, JSON_THROW_ON_ERROR);

        return new self("Cannot insert data '$stringData' to database", self::EXECUTE_INSERT_FAILED);
    }

    /**
     * @throws \JsonException
     */
    public static function executeUpdateFailed(array $data): self
    {
        $stringData = json_encode($data, JSON_THROW_ON_ERROR);

        return new self("Cannot update data '$stringData'", self::EXECUTE_UPDATE_FAILED);
    }

    public static function executeDeleteFailed(int $id): self
    {
        return new self("Cannot delete data by id '$id'", self::EXECUTE_DELETE_FAILED);
    }

    public static function executeSelectManyFailed(array $ids): self
    {
        $implodeIds = implode(', ', $ids);

        return new self("Cannot select by ids '$implodeIds'", self::EXECUTE_SELECT_MANY_FAILED);
    }
}
