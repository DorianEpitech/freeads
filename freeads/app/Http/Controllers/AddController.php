<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Events\AddCreated;
use App\Models\Add;
use Illuminate\Support\Facades\Storage;


class AddController extends Controller
{
    public function create(): View
    {
        return view('announces.newadd');
    }

    public function store(Request $request): RedirectResponse
    {   
        
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer'],
            'picture' => ['file', 'mimes:jpeg,png,jpg,svg'],
        ]);

        $pictureNames = [];
        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $image) {
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('images', $imageName, 'public');
                $pictureNames[] = $imageName;
            }
        }

        $announce = Add::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'picture' => implode('-', $pictureNames),
            'user_id' => auth()->user()->id
        ]);

        event(new AddCreated($announce));

        return redirect(RouteServiceProvider::ADDS);
    }


    public function index()
    {
        $adds = Add::where('user_id', '!=', auth()->user()->id)->get();
        return view('announces.adds', ['adds' => $adds]);
    }

    public function myAdds()
    {
        $user = auth()->user();
        $adds = $user->adds;
        return view('announces.myadds', ['adds' => $adds]);
    }

    public function editAdd($id)
    {
        $add = Add::findOrFail($id);
        return view('announces.editadd', ['add' => $add]);
    }

    public function updateAdd(Request $request)
    {

        $add = Add::findOrFail($request->input('add_id'));

        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer'],
            'picture' => ['file', 'mimes:jpeg,png,jpg,svg'],
        ]);

        if ($request->hasFile('pictures')) {
            $oldPictures = $add->picture;

            if ($oldPictures) {
                
                if (strpos($add->picture, '-') !== false) {
                    $pictures = explode('-', $add->picture);
            
                    foreach ($pictures as $picture) {
                        Storage::delete('public/images/' . $picture);
                    }

                } else {
                    Storage::delete('public/images/' . $oldPictures);
                }
            }

            $pictures = [];
            foreach ($request->file('pictures') as $picture) {
                $pictureName = uniqid() . '.' . $picture->getClientOriginalExtension();
                $picture->storeAs('public/images', $pictureName);
                $pictures[] = $pictureName;
            }

            $validatedData['picture'] = implode('-', $pictures);
        }

        $add->update($validatedData);

        return redirect(RouteServiceProvider::MYADDS);
    }

    public function deleteAdd($id)
    {
        $add = Add::findOrFail($id);
        $add->delete();

        if (!empty($add->picture)) {
            if (strpos($add->picture, '-') !== false) {
                $pictures = explode('-', $add->picture);
        
                foreach ($pictures as $picture) {
                    Storage::delete('public/images/' . $picture);
                }

            } else {
                Storage::delete('public/images/' . $add->picture);
            }
        }

        return redirect(RouteServiceProvider::MYADDS);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $keywords = $request->get('keywords');

        $adds = Add::query()
            ->where('user_id', '!=', auth()->user()->id)
            ->where(function ($query) use ($search, $minPrice, $maxPrice, $keywords) {

                if (!empty($search)) {
                    $query->where('title', 'like', "%$search%");
                }

                if (!empty($minPrice) && !empty($maxPrice)) {
                    $query->whereBetween('price', [$minPrice, $maxPrice]);

                } else if (!empty($minPrice)) {
                    $query->where('price', '>=', $minPrice);

                } else if (!empty($maxPrice)) {
                    $query->where('price', '<=', $maxPrice);
                }
                
                if (!empty($keywords)) {
                    $query->where(function ($query) use ($keywords) {
                        foreach (explode(' ', $keywords) as $keyword) {
                            $query->orWhere('description', 'like', "%$keyword%");
                        }
                    });
                }
            });
        
        $adds = $adds->get();
        return view('announces.adds', ["adds" => $adds]);
    }

}
