<?php

namespace App\Repositories;

use App\Mandate;
use Carbon\Carbon;

class MandateRepository extends BaseRepository
{
    /**
     * @var string
     */
    protected $model_class = Mandate::class;

    /**
     * Get current activated mandates
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getActives()
    {
        return $this->newQuery()
                    ->whereNull('date_to')
                    ->get();
    }

    public function isActive($user_id)
    {
        return $this->newQuery()
                    ->where('user_id', $user_id)
                    ->whereNull('date_to')
                    ->count() > 0;
    }

    /**
     * Deactivate (set the date_to column) a current mandate
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function deactivate($id)
    {
        $mandate = $this->find($id);

        $mandate->fill(['date_to' => Carbon::now()]);
        $mandate->save();

        return $mandate;
    }
}