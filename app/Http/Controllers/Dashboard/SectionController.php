<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Section;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SectionStoreRequest;
use App\Http\Requests\Dashboard\SectionUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SectionController extends Controller
{
     public function index()
    {
        DB::beginTransaction();

        try {
            $section = Section::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->success('Section list is successfully retrived', $section);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(SectionStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $payload = collect($request->validated())
                ->toArray();    
            $section = Section::create($payload);

            DB::commit();

            return $this->success('Section is successfully created', $section);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();

        try {
            $section = Section::findOrFail($id);

            DB::commit();

            return $this->success('Section is successfully retrived', $section);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(SectionUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $section = Section::findOrFail($id);
            $payload = collect($request->validated())
                ->toArray();
            $section->update($payload);

            DB::commit();

            return $this->success('Section is successfully updated', $section);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $section = Section::findOrFail($id);
            $section->delete();

            DB::commit();

            return $this->success('Section is successfully deleted', $section);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
