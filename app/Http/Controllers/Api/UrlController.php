<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UrlRequest;
use App\Http\Resources\Api\UrlResource;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = Auth::user()->urls()->get();
        return UrlResource::collection($urls)->additional(["success" => 1, "message" => trans("app.return_success")]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UrlRequest $request)
    {
        $code = $this->getShortUrl($request->url);
        $url = Url::create($request->validated() + ["code" => $code]);
        Auth::user()->urls()->save($url);
        return UrlResource::make($url)->additional(["success" => 1, "message" => trans("app.return_success")]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Url $url
     * @return \Illuminate\Http\Response
     */
    public function show(Url $url)
    {
        return UrlResource::make($url)->additional(["success" => 1, "message" => trans("app.return_success")]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Url $url
     * @return \Illuminate\Http\Response
     */
    public function update(UrlRequest $request, Url $url)
    {
        if (Auth::id() != $url->user_id) return $this->sendError(trans("auth.Unauthorized"));
        $code = $this->getShortUrl($request->url);
        $url->fill($request->validated() + ["code" => $code])->save();
        Auth::user()->urls()->save($url);
        return UrlResource::make($url)->additional(["success" => 1, "message" => trans("app.return_success")]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Url $url
     * @return \Illuminate\Http\Response
     */
    public function destroy(Url $url)
    {
        if (Auth::id() != $url->user_id) return $this->sendError(trans("auth.Unauthorized"));
        $url->delete();
        return response()->json(["success" => 1, "message" => trans("app.delete_success")]);

    }

    public function getShortUrl($long_url)
    {
        $code = Str::random(7);
        if (!empty(Url::where("code", $code)->first())) $this->getShortUrl($long_url);
        return $code;
    }

    public function shortened($url)
    {
        $url = Url::where("code", $url)->select("id", "url", "visits_number")->firstorfail();
        $url->increment("visits_number");
        return redirect($url->url);
    }

    public function htmlUrl($url)
    {
        $long_url = Url::where("code", $url)->select("id", "url", "visits_number")->firstorfail();
        $long_url->increment("visits_number");
        $long_url = $long_url->url;
        return view("url.show", compact("long_url"));
    }
}

