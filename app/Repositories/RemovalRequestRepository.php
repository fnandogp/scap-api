<?php

namespace App\Repositories;

use App\RemovalRequest;

class RemovalRequestRepository extends BaseRepository
{
    /**
     * @var string
     */
    protected $model_class = RemovalRequest::class;


    /**
     * Get only the released national removal requests
     */
    public function getNonManifestedNationalReleased()
    {
        return $this->newQuery()
                    ->where('type', 'national')
                    ->where('status', 'released')
                    ->has('opinions', '<', 1)
                    ->get();
    }


    /**
     * Set approved status to a removal request
     *
     * @param $id
     *
     * @param $status
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function updateStatus($id, $status)
    {
        $removal_request = $this->find($id);
        $removal_request->fill(['status' => $status]);
        $removal_request->save();

        return $removal_request;
    }


    /**
     * @param $id
     * @param $user_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function setRapporteur($id, $user_id)
    {
        $removal_request = $this->find($id);
        $removal_request->fill(['rapporteur_id' => $user_id]);
        $removal_request->save();

        return $removal_request;
    }


    /**
     * Update removal request status set the reason
     *
     * @param $id
     * @param $reason
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function cancel($id, $reason)
    {
        $removal_request = $this->find($id);
        $removal_request->fill([
            'cancellation_reason' => $reason,
            'status'              => 'cancelled',
        ]);
        $removal_request->save();

        return $removal_request;
    }


    /**
     * Get only the removal request that the current user created
     *
     * @param int $take
     * @param bool $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllMine($take = 15, $paginate = true)
    {
        $user = \Auth::user();

        $query = $this->newQuery();
        $query->where('user_id', $user->id);

        return $this->doQuery($query, $take, $paginate);
    }
}