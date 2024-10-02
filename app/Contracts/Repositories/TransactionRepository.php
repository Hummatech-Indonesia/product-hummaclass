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
    /**
     * Method get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->transaction->query()->get();
    }
    /**
     * Method getWhere
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function getWhere(array $data): mixed
    {
        return $this->transaction->where($data)->get();
    }

    /**
     * Method show
     *
     * @param mixed $id [explicite description]
     *
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->transaction->with(['voucher', 'user', 'course'])->findOrFail($id);
    }
    /**
     * Method store
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->transaction->create($data);
    }
    /**
     * Method update
     *
     * @param $id $id [explicite description]
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update($id, array $data): mixed
    {
        return $this->show($id)->update($data);
    }
    /**
     * Method delete
     *
     * @param mixed $id [explicite description]
     *
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->show($id)->destroy();
    }
}
