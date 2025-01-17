<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\PaymentInterface;
use App\Contracts\Interfaces\IndustryClass\ZoomInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Zoom;

class PaymentRepository extends BaseRepository implements PaymentInterface
{
    public function __construct(Payment $payment)
    {
        $this->model = $payment;
    }

    /**
     * get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->get();
    }

    /**
     * store
     *
     * @param  mixed $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()->where('reference', $id)->first();
    }
}
