<?php

namespace Modules\Certificate\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Certificate\Http\Requests\CertificateTemplateRequest;
use Modules\Certificate\Http\Requests\CertificateTemplateUpdateRequest;
use Modules\Certificate\Interfaces\CertificateTemplateInterface;

class CertificateTemplateController extends Controller
{
    use ApiReturnFormatTrait;

    protected $template;

    // constructor injection
    public function __construct(
        CertificateTemplateInterface $templateInterface
    ) {
        $this->template = $templateInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {

        try {
            $data['templates'] = $this->template->model()->search($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('certificate.Certificate Template List'); // title
            return view('certificate::templates.index', compact('data')); // view
        } catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function create()
    {
        try {
            $data['title'] = ___('certificate.Add Certificate Template'); // title
            $data['button'] = ___('common.Save');
            return view('certificate::templates.create', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function store(CertificateTemplateRequest $request)
    {
        try {
            $result = $this->template->store($request);
            if ($result->original['result']) {
                return redirect()->route('admin.certificate.template.index')->with('success', $result->original['message']); // return success response
            } else {
                return redirect()->back()->with('danger', $result->original['message']); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $data['template'] = $this->template->model()->where('id', $id)->first(); // data
            if (!$data['template']) {
                return redirect()->back()->with('danger', ___('alert.template_not_found'));
            }
            $data['title'] = ___('certificate.Edit Certificate Template'); // title
            $data['button'] = ___('common.Save');
            return view('certificate::templates.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CertificateTemplateUpdateRequest $request, $id)
    {
        try {
            $result = $this->template->update($request, $id);

            if ($result->original['result']) {
                return redirect()->route('admin.certificate.template.index')->with('success', $result->original['message']); // return success response
            } else {
                return redirect()->back()->with('danger', $result->original['message']); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $result = $this->template->destroy($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']); // return success response
            } else {
                return redirect()->back()->with('danger', $result->original['message']); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
