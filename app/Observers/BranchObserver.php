<?php

namespace App\Observers;

use App\Models\Branch;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Illuminate\Http\Request;
class BranchObserver
{
    /**
     * Handle the Branch "created" event.
     *
     * @param  \App\Models\Branch  $branch
     * @return void
     */
    public function created(Branch $branch)
    {
        // Nova::whenServing(function (NovaRequest $request) use ($branch) {
        //     $branch->region_id = intval($request->region_id);
        // }, function (Request $request) use ($branch) {
        //     // Invoked for non-Nova requests...
        // });
       
    }

    /**
     * Handle the Branch "updated" event.
     *
     * @param  \App\Models\Branch  $branch
     * @return void
     */
    public function updated(Branch $branch)
    {
        // Nova::whenServing(function (NovaRequest $request) use ($branch) {
        //     $branch->region_id = intval($request->region_id);
        //     $branch->save();
        // }, function (Request $request) use ($branch) {
        //     // Invoked for non-Nova requests...
        // });
    }

    /**
     * Handle the Branch "deleted" event.
     *
     * @param  \App\Models\Branch  $branch
     * @return void
     */
    public function deleted(Branch $branch)
    {
        //
    }

    /**
     * Handle the Branch "restored" event.
     *
     * @param  \App\Models\Branch  $branch
     * @return void
     */
    public function restored(Branch $branch)
    {
        //
    }

    /**
     * Handle the Branch "force deleted" event.
     *
     * @param  \App\Models\Branch  $branch
     * @return void
     */
    public function forceDeleted(Branch $branch)
    {
        //
    }
}
