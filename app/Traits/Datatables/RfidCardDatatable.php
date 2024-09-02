<?php

namespace App\Traits\Datatables;

use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

trait RfidCardDatatable
{

    public function rfidCardMockup(mixed $collection): JsonResponse
    {
        return DataTables::of($collection)
            ->addIndexColumn()
            ->editColumn('photo', function ($data) {
                return view('dashboard.pages.packages.rfid-cards.datatables.photo', compact('data'));
            })
            ->editColumn('user_id', function ($data) {
                return view('dashboard.pages.packages.rfid-cards.datatables.user_id', compact('data'));
            })
            ->editColumn('status', function ($data) {
                return view('dashboard.pages.packages.rfid-cards.datatables.status', compact('data'));
            })
            ->editColumn('action', function ($data) {
                return view('dashboard.pages.packages.rfid-cards.datatables.action', compact('data'));
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
