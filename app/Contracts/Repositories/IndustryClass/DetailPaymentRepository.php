<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\DetailPaymentInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Enums\InvoiceStatusEnum;
use App\Models\Classroom;
use App\Models\DetailPayment;

class DetailPaymentRepository extends BaseRepository implements DetailPaymentInterface
{
    public function __construct(DetailPayment $detailPayment)
    {
        $this->model = $detailPayment;
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

    public function getByClassroom(Classroom $classroom, array $months, int $year): mixed
    {
        $detailPayments = $this->model->query()
            ->whereHas('payment', function ($query) use ($classroom) {
                $query->whereHas('user.student.studentClassrooms', function ($query) use ($classroom) {
                    $query->where('classroom_id', $classroom->id);
                })
                ->where('invoice_status', InvoiceStatusEnum::PAID->value); 
            })
            ->whereIn('month', $months)
            ->where('year', $year) 
            ->with(['payment.user'])
            ->get();

            $payments = $detailPayments->groupBy(function ($detailPayment) {
                return $detailPayment->payment->user_id;
            })->values();
        return $payments;
    }
}
