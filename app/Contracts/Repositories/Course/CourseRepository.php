<?php

namespace App\Contracts\Repositories\Course;

use App\Contracts\Interfaces\Course\CategoryInterface;
use App\Contracts\Interfaces\Course\CourseInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseRepository extends BaseRepository implements CourseInterface
{
    /**
     * Method __construct
     *
     * @param Course $course [explicite description]
     *
     * @return void
     */
    public function __construct(Course $course)
    {
        $this->model = $course;
    }
    /**
     * Method customPaginate
     *
     * @param Request $request [explicite description]
     * @param int $pagination [explicite description]
     *
     * @return LengthAwarePaginator
     */
    public function customPaginate(Request $request, int $pagination = 9): LengthAwarePaginator
    {
        return $this->model->query()
            ->with('modules')
            ->withCount('userCourses')
            ->when($request->search, function ($query) use ($request) {
                $query->whereLike('name', $request->search);
            })
            ->when($request->order == "best seller", function ($query) {
                $query->orderBy('user_courses_count', 'desc');
            })
            ->when($request->categories, function ($query) use ($request) {
                $query->whereIn('sub_category_id', $request->categories);
            })
            ->when($request->maximum, function ($query) use ($request) {
                $query->where('price', '<=', $request->maximum);
            })
            ->when($request->minimum, function ($query) use ($request) {
                $query->where('price', '>=', $request->minimum);
            })
            ->orderBy('created_at', 'desc')
            ->fastPaginate($pagination);
    }

    /**
     * search
     *
     * @param  mixed $request
     * @return mixed
     */
    public function search(Request $request): mixed
    {
        return $this->model->query()
            ->with('modules')
            ->withCount('userCourses')
            ->when($request->search, function ($query) use ($request) {
                $query->whereLike('name', $request->search);
            })
            ->when($request->order == "best seller", function ($query) {
                $query->orderBy('user_courses_count', 'desc');
            })
            ->when($request->sub_category, function ($query) use ($request) {
                $query->whereIn('sub_category', $request->sub_category);
            })
            ->when($request->maksimum && $request->minimum, function ($query) use ($request) {
                $query->where('price', '>=', $request->minimum)->where('price', '<=', $request->maksimum);
            })
            ->orderBy('created_at', 'desc')
            ->get();
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
        return $this->model->query()->create($data);
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
    /**
     * Method showWithSlug
     *
     * @param string $slug [explicite description]
     *
     * @return mixed
     */
    public function showWithSlug(string $slug): mixed
    {
        return $this->model->query()->where(['slug' => $slug])->firstOrFail();
    }
    /**
     * Method update
     *
     * @param mixed $id [explicite description]
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
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
        return $this->show($id)->delete();
    }

    /**
     * getWhere
     *
     * @param  mixed $data
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->whereHas('userCourses', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->fastPaginate(9);
    }
}
