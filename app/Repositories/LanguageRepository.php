<?php

namespace App\Repositories;

use App\Models\Language;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\File;
use App\Interfaces\LanguageInterface;
use Illuminate\Support\Facades\Session;

class LanguageRepository implements LanguageInterface
{

    use ApiReturnFormatTrait;

    private $model;

    public function __construct(Language $model)
    {
        $this->model = $model;
    }

    public function model()
    {
       return $this->model;
    }

    public function all()
    {
        return Language::all();
    }

    public function getAll()
    {
        return Language::latest()->paginate(5);
    }

    public function store($request)
    {
        try {
            $languageStore = new $this->model;
            $languageStore->name = $request->name;
            $languageStore->code = $request->code;
            $languageStore->icon_class = $request->flagIcon;
            $languageStore->direction = $request->direction;
            $languageStore->save();
            return $this->responseWithSuccess(___('alert.language_created_successfully'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.language_created_failed'));
        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        try {
            $language = $this->model->findOrfail($id);
            $language->name = $request->name;
            $language->code = $request->code;
            $language->icon_class = $request->flagIcon;
            $language->direction = $request->direction;

            $language->save();
            return $this->responseWithSuccess(___('alert.language_updated_successfully'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.language_updated_failed'));
        }
    }

    public function destroy($id)
    {
        try {
            $languageDestroy = $this->model->find($id);
            // delete directory
            File::deleteDirectory(base_path('lang/' . $languageDestroy->code));
            $languageDestroy->delete();
            return $this->responseWithSuccess(___('alert.language_deleted_successfully'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.language_deleted_failed'));
        }
    }

    public function terms($id)
    {
        try {
            $data['title'] = ___('common.Language Terms');
            $data['language'] = $this->show($id);
            $path = base_path('lang/' . $data['language']->code);

            if (!File::isDirectory($path)):
                File::makeDirectory($path, 0777, true, true);
                File::copyDirectory(base_path('lang/en'), base_path('lang/' . $data['language']->code));

            endif;

            if (File::isDirectory($path)) {
                $jsonFile = base_path("lang/" . $data['language']->code . "/common.json");
                if(!File::exists($jsonFile)){
                    $dataString = json_decode(file_get_contents(base_path('lang/en/common.json')), true);  
                    $newJsonString = json_encode($dataString, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    file_put_contents($jsonFile, stripslashes($newJsonString));
                }
                $jsonString = file_get_contents(base_path("lang/" . $data['language']->code . "/common.json"));
            } else {
                $jsonString = file_get_contents(base_path('lang/en/common.json'));
            }
            $data['terms'] = json_decode($jsonString, true);
            $data['modules'] = scandir(base_path('lang/' . $data['language']->code));
            return $this->responseWithSuccess(___('common.data_found'), $data, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.language_terms_failed'));
        }
    }

    function languageChange($code){
        try {
            $path = base_path('lang/' . $code);
            if (is_dir($path)) {
                $lang = $this->model->where('code', $code)->select('direction')->first();
                if ($lang->direction == 'rtl') {
                    Session::put('rtl', true);
                } else {
                    Session::put('rtl', false);
                }
                Session::put('locale', $code);
                return $this->responseWithSuccess(___('alert.language_updated_successfully'));
            }
            return $this->responseWithError(___('alert.language_terms_failed'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.language_terms_failed'));
        }
    }

    public function termsUpdate($request, $code)
    {
        try {
            $path = base_path('lang/' . $code);

            if (!File::isDirectory($path)):
                File::makeDirectory($path, 0777, true, true);
                File::copyDirectory(base_path('lang/en'), base_path('lang/' . $code));
            endif;

            $jsonFile = "$path/$request->lang_module";
            $ext = pathinfo($jsonFile, PATHINFO_EXTENSION);
            if (@$ext != 'json') {
                $jsonFile = "$path/$request->lang_module.json";
            }
            $jsonString = File::exists($jsonFile)
            ? file_get_contents($jsonFile)
            : file_get_contents(base_path('lang/en/common.json'));

            $data = json_decode($jsonString, true);

            if($request->name && $request->value){
                $data[str_replace('_', ' ', $request->name)] = $request->value;
            }else{
                return $this->responseWithError(___('alert.language_terms_updated_failed'));
            }

            $newJsonString = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents($jsonFile, stripslashes($newJsonString));
            return $this->responseWithSuccess(___('alert.language_terms_updated_successfully'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.language_terms_updated_failed'));
        }
    }
}
