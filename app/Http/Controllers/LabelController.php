<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Label::all();
        return response()
            ->view('label.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Label::class);

        return response()
            ->view('label.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Label::class);

        $data = $this->validate($request, [
            'name' => 'required|unique:labels,name',
            'description' => 'nullable'
        ]);
        $label = new Label();
        $label->fill($data);
        $label->save();

        flash('Метка успешно создана')->success();
        return redirect()
            ->route('labels.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        $this->authorize('update', $label);

        return response()
            ->view('label.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Label $label)
    {
        $this->authorize('update', $label);

        $data = $this->validate($request, [
            'name' => 'required|unique:labels,name',
            'description' => 'nullable'
        ]);
        $label->fill($data);
        $label->save();

        flash('Метка успешно изменена')->success();
        return redirect()
            ->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Label $label)
    {
        $this->authorize('delete', $label);

        $taskWithLabelCount = $label->tasks()->count();
        if ($taskWithLabelCount === 0) {
            $label->delete();
            flash('Метка успешно удалена')->success();
            return redirect()
                ->route('labels.index');
        }

        flash('Не удалось удалить метку')->error();
        return back();
    }
}
