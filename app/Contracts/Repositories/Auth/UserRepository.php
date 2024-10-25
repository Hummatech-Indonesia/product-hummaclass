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