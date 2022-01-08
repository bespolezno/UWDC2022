<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSessionRequest;
use App\Http\Requests\UpdateSessionRequest;
use App\Http\Resources\SessionResource;
use App\Models\Category;
use App\Models\Session;
use App\Models\Tag;
use App\Models\Type;
use Illuminate\Http\Exceptions\HttpResponseException;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(SessionResource::collection(auth()->user()->sessions));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateSessionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSessionRequest $request)
    {
        $category = Category::firstOrCreate(['name' => $request->category]);
        $type = Type::firstOrCreate(['name' => $request->type]);
        $tags = collect($request->tags)->map(fn($tag) => Tag::firstOrCreate(['name' => $tag]));

        $session = Session::create([
            'user_id' => auth()->id(),
            'type_id' => $type->id,
            'category_id' => $category->id,
            'date' => $request->date,
            'hours' => $request->hours,
            'notes' => $request->notes,
        ]);

        $session->tags()->sync($tags->map->id);

        return response()->json(SessionResource::make($session), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Session $session
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Session $session)
    {
        if (auth()->id() !== $session->user_id)
            throw new HttpResponseException(response()->json(['message' => 'This is not your session'], 401));

        return response()->json(SessionResource::make($session));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSessionRequest $request
     * @param \App\Models\Session $session
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSessionRequest $request, Session $session)
    {
        if (auth()->id() !== $session->user_id)
            throw new HttpResponseException(response()->json(['message' => 'This is not your session'], 401));

        $category = Category::firstOrCreate(['name' => $request->category]);
        $type = Type::firstOrCreate(['name' => $request->type]);
        $tags = collect($request->tags)->map(fn($tag) => Tag::firstOrCreate(['name' => $tag]));

        $session->update([
            'type_id' => $type->id,
            'category_id' => $category->id,
            'date' => $request->date,
            'hours' => $request->hours,
            'notes' => $request->notes,
        ]);

        $session->tags()->sync($tags->map->id);

        return response()->json(SessionResource::make($session));
    }
}
