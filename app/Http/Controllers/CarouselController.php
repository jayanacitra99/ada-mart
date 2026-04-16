<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'carousels' => Carousel::all()
        ];
        return view('Admin.carousels', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.carousel_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => [
                'required',
                'string',
                Rule::unique('carousels','name')
            ],
            'status'    => 'required|string',
            'show_date' => 'required|string',
            'image'     => 'required|image|max:2048'
        ]);

        $dates = explode(' - ', $request->show_date);

        $show_from = Carbon::createFromFormat('m/d/Y H:i', $dates[0])->format('Y-m-d H:i:s');
        $show_until = Carbon::createFromFormat('m/d/Y H:i', $dates[1])->format('Y-m-d H:i:s');

        $carousel = new Carousel();
        $carousel->name = $request->name;
        $carousel->status = $request->status;
        $carousel->show_from = $show_from;
        $carousel->show_until = $show_until;
        $carousel->image = 'carousels/no-image.png';
        $carousel->save();

        if(!is_null($request->image)){
            // Get the image file
            $image = $request->file('image');

            // Generate a unique name for the image
            $imageName = 'Carousel-'.$carousel->id.'_'.time() . '.' . $image->extension();
            // Store the image
            $image->move(public_path('carousels'),$imageName);
            $carousel->image = 'carousels/'.$imageName;
            $carousel->save();
        }
        $options = [
            'type' => 'success',
            'text' => 'Carousel Created',
        ];
        Session::flash('notif',$options);
        return \redirect('admin/carousels');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'carousel'  => Carousel::find($id),
        ];
        return view('Admin.carousel_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'      => [
                'sometimes',
                'required',
                'string',
                Rule::unique('carousels','name')->ignore($id)
            ],
            'status'    => 'sometimes|required|string',
            'show_date' => 'sometimes|required|string',
            'image'     => 'sometimes|required|image|max:2048'
        ]);

        $dates = explode(' - ', $request->show_date);

        $show_from = Carbon::createFromFormat('m/d/Y H:i', $dates[0])->format('Y-m-d H:i:s');
        $show_until = Carbon::createFromFormat('m/d/Y H:i', $dates[1])->format('Y-m-d H:i:s');

        $carousel = Carousel::find($id);
        if(!is_null($request->image)){
            if (file_exists(public_path($carousel->image)) && !str_contains($carousel->image, 'no-image.png')) {
                unlink(public_path($carousel->image));
            }
            // Get the image file
            $image = $request->file('image');

            // Generate a unique name for the image
            $imageName = 'Carousel-'.$id.'_'.time() . '.' . $image->extension();
            // Store the image
            $image->move(public_path('carousels'),$imageName);
            $carousel->image = 'carousels/'.$imageName;
        }
        $carousel->name = $request->name;
        $carousel->status = $request->status;
        $carousel->show_from = $show_from;
        $carousel->show_until = $show_until;
        $carousel->save();

        $options = [
            'type' => 'success',
            'text' => 'Carousel Created',
        ];
        Session::flash('notif',$options);
        return \redirect('admin/carousels');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $carousel = Carousel::find($id);
        $delete = Carousel::destroy($id);

        if ($delete){
            // Delete the image from public directory
            if (file_exists(public_path($carousel->image)) && !str_contains($carousel->image, 'no-image.png')) {
                unlink(public_path($carousel->image));
            }
        }

        return $delete;
    }

    public function setPopUp(Request $request){
        $carousel = Carousel::find($request->carousel_id);
        if($carousel->is_show or $carousel->status == 'active'){
            Carousel::where('is_popup', true)->update(['is_popup' => false]);
            $carousel->is_popup = true;
            $carousel->save();
            $notif = [
                'notif' => [
                    'text' => 'Pop-Up has been set up',
                ],
            ];
            return response()->json($notif);
        } else {
            if(!$carousel->is_show){
                return response()->json(['error' => 'Carousel is not in show date'], 404);
            }
            if($carousel->status == 'inactive'){
                return response()->json(['error' => 'Carousel status is inactive'], 404);
            }
        }
        
    }
}
