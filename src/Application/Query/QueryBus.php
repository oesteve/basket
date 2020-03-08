<?php

namespace App\Application\Query;

interface QueryBus
{
    /**
     * @return mixed Query response
     */
    public function query(Query $query);
}
