<?php

namespace Habib\TranslationManager\Controllers;


use Habib\TranslationManager\Exceptions\InvalidNamespaceException;
use Habib\TranslationManager\Manager;
use Habib\TranslationManager\Requests\TranslationRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

/**
 * Class Controller
 *
 * @package Habib\TranslationManager
 */
class Controller extends BaseController
{

    use ValidatesRequests;

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->manager = new Manager;
    }

    /**
     * Display index page of translation
     *
     * @return Factory|View
     */
    public function index()
    {
        $namespaces = $this->manager->namespaces();
//        dd($this->manager);
        return view('translation_manager::index', compact('namespaces'));
    }

    /**
     * Display edit form page
     *
     * @param string $language
     * @param string $file
     * @param string|null $namespace
     *
     * @return Factory|View
     */
    public function edit($language, $file, $namespace = null)
    {
        $translations = $this->manager->translations($file, $namespace);
        $prefix = ($namespace ? "{$namespace}::" : "") . "{$this->manager->groupName($file)}.";

        return view(
            'translation_manager::edit',
            compact('language', 'file', 'namespace', 'translations', 'prefix')
        );
    }

    /**
     * Save translation file
     *
     * @param TranslationRequest $request
     * @param string $language
     * @param string $file
     * @param string|null $namespace
     *
     * @return RedirectResponse
     */
    public function update(TranslationRequest $request, $language, $file, $namespace = null)
    {

        $keys = array_keys((array)$this->manager->translations($file, $namespace));

        $this->manager->exportFile($request->only($keys), $file, $language, $namespace);

        return redirect()
            ->route('translation_manager.index')
            ->with('message', 'Translation added successfully');
    }

    /**
     * get array of namespace's files
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws InvalidNamespaceException
     */
    public function files(Request $request)
    {
        $request->validate(['namespace' => 'nullable|string']);

        return new JsonResponse($this->manager->files($request->get('namespace')));
    }
}
