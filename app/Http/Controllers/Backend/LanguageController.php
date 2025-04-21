<?php

namespace App\Http\Controllers\Backend;

use App;
use App\Http\Controllers\Controller;
use App\Http\Requests\Language\LanguageStoreRequest;
use App\Http\Requests\Language\LanguageUpdateRequest;
use App\Interfaces\FlagIconInterface;
use App\Interfaces\LanguageInterface;
use App\Interfaces\PermissionInterface;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{

    use ApiReturnFormatTrait;

    private $language;
    private $permission;
    private $flagIcon;

    public function __construct(LanguageInterface $languageInterface, PermissionInterface $permissionInterface, FlagIconInterface $flagIconInterface)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')) {
            abort(400);
        }
        $this->language = $languageInterface;
        $this->permission = $permissionInterface;
        $this->flagIcon = $flagIconInterface;
    }

    public function index()
    {
        $data['languages'] = $this->language->getAll();
        $data['title'] = ___('common.languages');
        return view('backend.languages.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = ___('common.create_language');
        $data['permissions'] = $this->permission->all();
        $data['flagIcons'] = $this->flagIcon->getAll();
        return view('backend.languages.create', compact('data'));
    }

    public function store(LanguageStoreRequest $request)
    {
        try {
            if (env('APP_DEMO')) {
                return redirect()->back()->with('danger', ___('alert.you_can_not_change_in_demo_mode'));
            }
            $result = $this->language->store($request);
            if ($result->original['result']) {
                return redirect()->route('languages.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {

        }
    }

    public function edit($id)
    {
        $data['language'] = $this->language->show($id);
        $data['title'] = ___('common.Edit language');
        $data['permissions'] = $this->permission->all();
        $data['flagIcons'] = $this->flagIcon->getAll();
        return view('backend.languages.edit', compact('data'));
    }

    public function update(LanguageUpdateRequest $request, $id)
    {
        try {
            if (env('APP_DEMO')) {
                return redirect()->back()->with('danger', ___('alert.you_can_not_change_in_demo_mode'));
            }

            $result = $this->language->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('languages.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function delete($id)
    {

        try {
            if (env('APP_DEMO')) {
                return redirect()->back()->with('danger', ___('alert.you_can_not_change_in_demo_mode'));
            }
            $result = $this->language->destroy($id);
            if ($result->original['result']) {
                return redirect()->route('languages.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('languages.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function terms($id)
    {
        $result = $this->language->terms($id);
        if ($result->original['result']) {
            $data = $result->original['data'];
            return view('backend.languages.terms', compact('data'));
        } else {
            return redirect()->back()->with('danger', $result->original['message']);
        }
    }

    public function termsUpdate(Request $request, $code)
    {
        try {

            if (env('APP_DEMO')) {
                return redirect()->back()->with('danger', ___('alert.you_can_not_change_in_demo_mode'));
            }

            $result = $this->language->termsUpdate($request, $code);
            if ($result->original['result']) {
                return $this->responseWithSuccess(___('alert.language_terms_updated_successfully'));
            } else {
                return $this->responseWithError(___('alert.language_terms_updated_failed'));
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.language_terms_updated_failed'));
        }
    }

    public function changeModule(Request $request)
    {
        $path = base_path('lang/' . $request->code);
        $jsonString = file_get_contents(base_path("lang/$request->code/$request->module"));
        $data['terms'] = json_decode($jsonString, true);
        $data['code'] = $request->code;
        return view('backend.languages.ajax_terms', compact('data'))->render();
    }

    public function changeLanguage(Request $request)
    {
        $path = base_path('lang/' . $request->code);
        if (is_dir($path)) {
            $lang = $this->language->model()->where('code', $request->code)->select('direction')->first();
            if ($lang->direction == 'rtl') {
                Session::put('rtl', true);
            } else {
                Session::put('rtl', false);
            }
            Session::put('locale', $request->code);
            return 1;
        }
        return 0;

    }

}
