<?php

namespace App\DTO\Pagination;

use App\DTO\DTO;

class PaginationFilterDTO implements DTO
{
    public array |null $filter;
    public int | null $page;
    public int | null $perPage;
    public array $relations;


    public function __construct(
        array | null $filter,
        int | null $perPage,
        int | null $page,
        array $relations
    )
    {
        $this->perPage = $perPage ?? 15;
        $this->page = $page ?? 1;
        $this->filter = $filter ?? [];
        $this->relations = $relations;
    }
}
