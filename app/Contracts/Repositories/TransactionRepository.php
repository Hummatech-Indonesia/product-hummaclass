<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\TransactionInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Transaction;

class TransactionRepository extends BaseRepository implements TransactionInterface
{
    private $transaction;
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function show(mixed $id): mixed
    {
        return $this->transaction->findOrFail($id);
    }
    public function store(array $data): mixed
    {
        return $this->transaction->create($data);
    }
    public function update($id, array $data): mixed
    {
        return $this->show($id)->update($data);
    }
    public function delete(mixed $id): mixed
    {
        return $this->show($id)->destroy();
    }
}
