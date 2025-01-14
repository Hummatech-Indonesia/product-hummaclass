<?php

namespace App\Helpers;

use App\Enums\InvoiceStatusEnum;

class PaymentHelper
{

    /**
     * getSemester
     *
     * @return void
     */
    public static function getSemester()
    {
        $month = intval(now()->format('n'));
        $data = [];
        if ($month >= 7 && $month <= 12) {
            $data = [
                'semester' => 'Ganjil',
                'month' => [7, 8, 9, 10, 11, 12]
            ];
        } else {
            $data = [
                'semester' => 'Genap',
                'month' => [1, 2, 3, 4, 5, 6]
            ];
        }
        return $data;
    }

    /**
     * semesterBill
     *
     * @return void
     */
    public static function paidMonth()
    {
        $year = intval(now()->format('Y'));

        $detailPayment = [];

        foreach (auth()->user()->payments->where('invoice_status', InvoiceStatusEnum::PAID->value) as $payment) {
            $details = $payment->detailPayments->where('year', $year);
            foreach ($details as $detail) {
                $detailPayment[] = $detail;
            }
        }
        return $detailPayment;
    }

    /**
     * semesterBill
     *
     * @return void
     */
    public static function semesterBill()
    {
        $paidMonth = self::paidMonth();
        if (empty($paidMonth)) {
            return self::monthlyBill() * 6;
        } else {
            $notYetPaid = count(self::getSemester()['month']) - count($paidMonth);
            return self::monthlyBill() * $notYetPaid;
        }
    }

    /**
     * monthlyBill
     *
     * @return void
     */
    public static function monthlyBill(): int
    {
        $studentClassroom = auth()->user()->student->studentClassrooms()->orderBy('created_at', 'desc')->first();
        $monthlyBill = $studentClassroom->classroom->price;

        return $monthlyBill;
    }
}
