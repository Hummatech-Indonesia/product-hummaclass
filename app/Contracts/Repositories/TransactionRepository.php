<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\EventInterface;
use App\Contracts\Interfaces\TransactionInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Enums\InvoiceStatusEnum;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionRepository extends BaseRepository implements TransactionInterface
{
    public function __construct(Transaction $transaction)
    {
        $this->model = $transaction;
    }
    /**
     * Method get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->get();
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
        return $this->model->where($data)->get();
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
        return $this->model->with(['courseVoucher', 'user', 'course.subcategory', 'event'])->findOrFail($id);
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
        return $this->model->create($data);
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

    /**
     * customPaginate
     *
     * @param  mixed $request
     * @param  mixed $pagination
     * @return LengthAwarePaginator
     */
    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()->when($request->name, function ($query) use ($request) {
            $query->whereRelation('user', 'name', 'LIKE', '%' . $request->name . '%');
        })->fastPaginate($pagination);
    }

    /**
     * search
     *
     * @param  mixed $request
     * @return mixed
     */
    public function search(Request $request): mixed
    {
        return $this->model->query()->when($request->name, function ($query) use ($request) {
            $query->where('user', 'name', 'LIKE', '%' . $request->name . '%');
        })->get();
    }

    public function countByMonth(): mixed
    {
        // Daftar bulan dalam format singkatan tanpa index
        $months = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        ];

        // Ambil data transaksi
        $transactions = $this->model->query()
            ->where('invoice_status', InvoiceStatusEnum::PAID)
            ->selectRaw('MONTH(created_at) as month_number, COUNT(*) as count')
            ->groupBy('month_number')
            ->orderBy('month_number')
            ->get()
            ->keyBy('month_number');

        // Siapkan hasil akhir sebagai array asosiatif
        $result = [];
        foreach ($months as $index => $month_name) {
            // Gunakan index + 1 untuk mencocokkan dengan nomor bulan
            $month_number = $index + 1;
            $result[$month_name] = $transactions->has($month_number) ? $transactions->get($month_number)->sum('paid_amount') : 0;
        }


        // dd(Carbon::now()->format('M'));
        $totalThisMount = $result[Carbon::now()->format('M')];

        return ['data' => $result, 'months' => $months, 'thisMountIncome' => $totalThisMount];
    }
}
