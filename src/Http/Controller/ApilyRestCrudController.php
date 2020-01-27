<?php
namespace ApilyRest\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApilyRestCrudController
{
    protected $modelI;
    protected $model;
    public function __construct()
    {
        $this->model = Str::studly($this->determineModel());
        if ($this->model !== '') {
            $namespace = 'App\\'.$this->model;
            $this->modelI = new $namespace();
        }
    }

    public function index()
    {
        return $this->modelI::paginate(config("apily.items"));
    }

    public function show($id)
    {
        return $this->modelI::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $obj = $this->modelI::find($id);
        event("api.{$this->model}.updated", $obj);
        $obj->fill($request->all());
        $obj->save();
    }

    public function destroy($id)
    {
        $obj = $this->modelI->find($id);
        event("api.{$this->model}.deleted", $obj);
        $obj->delete();
    }

    public function store(Request $request)
    {
        $obj = $this->modelI::create($request->all());
        event("api.{$this->model}.stored", $obj);
        return $obj;
    }

    private function determineModel()
    {
        $uri = str_replace(url("/"), "", url()->current());
        $uriSplits = explode("/", $uri);
        if(count($uriSplits) > 1) {
            $model = $uriSplits[2];

            return Str::slug($model);
        }
    }
}
