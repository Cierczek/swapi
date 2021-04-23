<?php


namespace App\Services;


use App\Http\Resources\People\PeopleCollection;
use App\Http\Resources\People\PeopleResource;
use App\Http\Resources\Starship\StarshipCollection;
use App\Http\Resources\Starship\StarshipResource;
use App\Models\Peoples;
use App\Models\Starships;
use Illuminate\Support\Facades\Http;

class SwapiService
{
    private $page = 1;
    private $data = [];

    final public static function get(string $resource, string $page)
    {
        $result = Http::get(url(config('services.swapi') . $resource), ['page' => $page]);
        return json_decode($result->body());
    }

    final public function importSwapiData(string $resource)
    {
        $response = $this::get($resource, $this->page);
        $this->data = array_merge($response->results, $this->data);

        if (!empty($response->next)) {
            $this->page++;
            $this->importSwapiData($resource);
        }

        $data = $this->prepareData($this->data, $resource);
        return $this->insertData($resource, $data);
    }

    final public function prepareData(array $data, string $resource)
    {
        foreach ($data as $datum) {
            if($resource === 'people'){
                $datum = new PeopleResource($datum);
            }

            if($resource === 'starship'){
                $datum = new StarshipResource($datum);
            }

            $result[] = collect($datum)->toArray();
        }

        return $result;
    }

    final public function insertData(string $table, array $data)
    {

        switch ($table) {
            case 'people':
                $result = Peoples::insert($data);
                break;
            case 'starships':
                $result = Starships::insert($data);
                break;
        }

        return $result;
    }
}