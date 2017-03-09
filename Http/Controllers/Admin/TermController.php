<?php

namespace Modules\Taxonomy\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Taxonomy\Entities\Term;
use Modules\Taxonomy\Entities\Vocabulary;
use Modules\Taxonomy\Http\Requests\CreateTermRequest;
use Modules\Taxonomy\Http\Requests\UpdateTermRequest;
use Modules\Taxonomy\Repositories\TermRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Taxonomy\Services\TaxonomyOrderer;
use Modules\Taxonomy\Services\TaxonomyRenderer;

class TermController extends AdminBaseController
{
    /**
     * @var TermRepository
     */
    private $term;
    private $taxonomyRenderer;
    private $taxonomyOrderer;

    public function __construct(
        TermRepository $term,
        TaxonomyRenderer $taxonomyRenderer,
        TaxonomyOrderer $taxonomyOrderer)
    {
        parent::__construct();

        $this->term = $term;
        $this->taxonomyRenderer = $taxonomyRenderer;
        $this->taxonomyOrderer = $taxonomyOrderer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $vocabulary_id
     * @return Response
     */
    public function index($vocabulary_id)
    {
        $vocabulary = Vocabulary::findOrFail($vocabulary_id);

        $terms = Term::roots()->where('vocabulary_id', $vocabulary_id)->get();
        $taxonomy_menu = $this->taxonomyRenderer->renderTaxonomyMenu($terms);

        return view('taxonomy::admin.terms.index', compact('taxonomy_menu', 'vocabulary'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $vocabulary_id
     * @return Response
     */
    public function create($vocabulary_id)
    {
        $vocabulary = Vocabulary::findOrFail($vocabulary_id);
        $terms = Term::getList($vocabulary->machine_name);

        return view('taxonomy::admin.terms.create', compact('vocabulary_id', 'terms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTermRequest $request
     * @return Response
     */
    public function store(CreateTermRequest $request)
    {
        $this->term->create($request);

        return redirect()->route('admin.taxonomy.term.index', [$request->input('vocabulary_id')])
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('taxonomy::terms.title.term')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $vocabulary_id
     * @param  Term $term
     * @return Response
     */
    public function edit($vocabulary_id, Term $term)
    {
        $vocabulary = Vocabulary::findOrFail($vocabulary_id);
        $terms = Term::getList($vocabulary->machine_name);

        $parent  = Term::where('id', $term->id)->first();
        foreach ($parent->getDescendantsAndSelf() as $descendant) {
            unset($terms[$descendant->id]);
        }

        return view('taxonomy::admin.terms.edit', compact('vocabulary_id', 'term', 'terms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Term $term
     * @param  UpdateTermRequest $request
     * @return Response
     */
    public function update(Term $term, UpdateTermRequest $request)
    {
        $this->term->update($term, $request);

        return redirect()->route('admin.taxonomy.term.index', [$request->input('vocabulary_id')])
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('taxonomy::terms.title.term')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $vocabulary_id
     * @param  Term $term
     * @return Response
     */
    public function destroy($vocabulary_id, Term $term)
    {
        $this->term->destroy($term);

        return redirect()->route('admin.taxonomy.term.index', [$vocabulary_id])
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('taxonomy::terms.title.term')]));
    }

    /*
     * Ajax function to rebuild tree
     */
    public function ajaxUpdate(Request $request)
    {
        $this->taxonomyOrderer->menuOrdererHandler($request->input('categories'));

        return response()->json(true);
    }
}
