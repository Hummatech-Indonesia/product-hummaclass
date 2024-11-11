<?php

namespace App\Contracts\Repositories\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Contracts\Interfaces\Auth\UserInterface;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }
    public function countUsersByMonth(): array
    {
        // Nama bulan dalam format singkat
        $months = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec'
        ];

        // Menghitung pengguna per bulan dari Januari hingga Desember untuk satu tahun terakhir
        $userCounts = $this->model->query()
            ->where('email', '!=', 'admin@gmail.com')
            ->where('created_at', '>=', now()->subYear())
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as user_count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('user_count', 'month')
            ->toArray();

        // Menyusun hasil dengan nama bulan dan menghitung total pengguna satu tahun terakhir
        $result = [];
        $totalUsersLastYear = 0;
        foreach ($months as $monthNumber => $monthName) {
            $userCount = $userCounts[$monthNumber] ?? 0;
            $result[$monthName] = $userCount;
            $totalUsersLastYear += $userCount;
        }

        // Menambahkan total pengguna satu tahun terakhir
        $result['total_last_year'] = $totalUsersLastYear;

        // Menghitung total pengguna keseluruhan (tanpa filter waktu)
        $totalUsersOverall = $this->model->query()
            ->where('email', '!=', 'admin@gmail.com')
            ->count();

        // Menambahkan total pengguna keseluruhan ke dalam hasil
        $result['total_overall'] = $totalUsersOverall;

        return $result;
    }
    /**
     * Method customPaginate
     *
     * @param Request $request [explicite description]
     * @param int $pagination [explicite description]
     *
     * @return LengthAwarePaginator
     */
    public function customPaginate(Request $request, int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->query()->when($request->name, function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        })->where('email', '!=', 'admin@gmail.com')->fastPaginate($pagination);
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
        return $this->model->query()->findOrFail($id);
    }

    public function update(mixed $id, array $data): mixed
    {
        return auth()->user()->forceFill([
            'password' => Hash::make($data['password'])
        ]);
    }
    /**
     * Method customUpdate
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function customUpdate(mixed $id, array $data): mixed
    {
        return $this->show($id)->update($data);
    }
}