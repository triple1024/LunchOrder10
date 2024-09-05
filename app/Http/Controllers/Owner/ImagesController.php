<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;
use App\Models\Food;
use App\Models\Image;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class ImagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function($request, $next){
            $id = $request->route()->parameter('image');//shopのid取得
            if(!is_null($id)){ //null判定
            $imagesOwnerId = Image::findOrFail($id)->owner->id;
                $imageId = (int)$imagesOwnerId;//キャスト文字列→数値に型変換
                if($imageId !== Auth::id()){
                    abort(404);//404画面表示
                }
            }
            return $next($request);
        });
    }

    public function index()
    {
        $images = Image::where('owner_id', Auth::id())
        ->orderBy('updated_at', 'desc')  //表示順
        ->paginate(20);

        return view('owner.images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadImageRequest $request)
    {
        // $imageFiles = $request->file('files');
        // if(!is_null($imageFiles)){
        //     foreach($imageFiles as $imageFile){
        //         $fileNameToStore = ImageService::upload($imageFile, 'products');
        //         Image::create([
        //             'owner_id' => Auth::id(),
        //             'filename' => $fileNameToStore,
        //         ]);
        //     }
        // }

        $imageFiles = $request->file('files');
        if (!is_null($imageFiles)) {
            foreach ($imageFiles as $imageFile) {
                // Cloudinaryに画像をアップロードし、結果を取得
                $uploadedFile = Cloudinary::upload($imageFile->getRealPath());

                // アップロード結果からURLとpublic_idを取得
                $uploadedFileUrl = $uploadedFile->getSecurePath();
                $publicId = $uploadedFile->getPublicId();

                // 画像情報をデータベースに保存
                Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $uploadedFileUrl, // CloudinaryのURLを保存
                    'public_id' => $publicId, // CloudinaryのPublic IDを保存（削除の際に使用）
                ]);
            }
        }


        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像登録を実施しました。',
        'status' => 'info']);


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
        $image = Image::findOrFail($id);
        return view('owner.images.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['string', 'max:50'],
        ]);

        $image = $request->image;
        $image = Image::findOrFail($id);
        $image->title = $request->title;
        $image->save();

        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像情報を更新しました。',
        'status' => 'info']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = Image::findOrFail($id);

        $imageInProducts = Food::where('image1', $image->id)
        ->get();

        if($imageInProducts){
            $imageInProducts->each(function ($product) use($image){
                if($product->image1 === $image->id){
                    $product->image1 = null;
                    $product->save();
                }
            });
        }

        // $filepath = 'public/products/' . $image->filename;

        // if(Storage::exists($filepath)){
        //     Storage::delete($filepath);
        // }

        // Cloudinaryから画像を削除
        Cloudinary::destroy($image->public_id); // public_idを使用して削除

        // データベースから画像情報を削除
        Image::findOrFail($id)->delete();

        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像を削除しました。',
        'status' => 'alert']);
    }
}
