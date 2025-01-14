<?php

namespace App\Http\Middleware;

use App\Helpers\PaymentHelper;
use App\Helpers\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentStudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $month = intval(now()->format('n'));
        $date = intval(now()->format('d')); // Mengambil tanggal saja sebagai integer

        $detailPayments = PaymentHelper::paidMonth();
        $months = [];
        foreach ($detailPayments as $detailPayment) {
            $months[] = $detailPayment->month;
        }

        if (in_array($month, $months)) {
            return $next($request);
        } elseif ($date <= 10) {
            return $next($request);
        } else {
            return ResponseHelper::error("NotPayment", "Silahkan selesaikan pembayaran Kelas Industri terlebih dahulu");
        }
    }
}
