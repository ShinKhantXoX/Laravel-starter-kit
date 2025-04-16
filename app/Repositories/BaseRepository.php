<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class BaseRepository implements IRepository
{
	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function all()
	{
		return $this->model->searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();
	}

	public function find($id)
	{
		return $this->model->find($id);
	}

	public function create(array $data)
	{
		return $this->model->create($data);
	}

	public function update($id, array $data)
	{
		$record = $this->model->find($id);
		if (!$record) {
				throw new \Exception('Record not found.');
		}
		$record->update($data);

		return $record->fresh();
	}

	public function updateWithFile($id, array $data, ?array $fileFields = null, string $dir = 'uploads')
	{

		$record = $this->model->find($id);
		if (!$record) {
			throw new \Exception('Record not found.');
		}

			// Check if $fileFields is provided and is an array
		if (!empty($fileFields) && is_array($fileFields)) {
			foreach ($fileFields as $field) {
				if (isset($data[$field]) && $data[$field] instanceof \Illuminate\Http\UploadedFile) {
					// Delete old file if it exists
					if ($record->$field) {
						\Storage::disk('public')->delete($record->$field);
					}

					// Store new file
					$data[$field] = $data[$field]->store($dir, 'public');
				}
			}
		}
		$record->update($data);
		return $record->fresh();
	}



	public function delete($id)
	{
		return $this->model->destroy($id);
	}

	public function createWithFile(array $data, array $fields, string $dir)
	{
		foreach ($fields as $field) {
			if (isset($data[$field])) {
				$data[$field] = $data[$field]->store($dir, 'public');
			}
		}

		return $this->model->create($data);
	}

	public function checkIsExists(int | array $id): bool
	{
		$isExists = false;

		if (is_array($id)) {
			foreach ($id as $modelId) {
				$model = $this->model->find($modelId);
				if ($model) $isExists = true;
			}

			return $isExists;
		}

		return boolval($this->model->find($id));
	}

	protected function format(array $data): array
	{
		$saveCopy = [];

		foreach ($data as $key => $value) {
			$saveCopy[Str::snake($key)] = $value;
		}

		return $saveCopy;
	}
}
