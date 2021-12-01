<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\CommentCTR;

class ProductCTR extends Controller
{
    
 ///==============================show all products===================================
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $allProducts = Product::all();
    }

    ///==============================store product===================================

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([   ///$request->input('name')
            'name' => 'required',
            'price'=> 'required',
            'catagory' => 'required',
            'contact'=>'required', 
            'quantity'=>'required',
            'expired_date'=>'required'
        ]);
            // $p = Products::create([
            //  'name' => 'required',
            //  'price'=> 'required',
            //  'catagory' => 'required',
            //  'contact'=>'required', 
            //  'quantity'=>'required',
            //  'expired_date'=>'required']
            // );

             $time = strtotime($request->expired_date);
             $timeToDate = date('Y-m-d',$time);

             if($request->has('image_temp'))
             {
                 $pic = $request->file('image_temp');
                 $picNN= time().".".$pic->getClientOriginalExtension();
                   $dest = public_path('/imgs');
                   $pic->move($dest,$picNN);
                   $image_src = url('/imgs').'/'.$picNN;
             }

             //Carbon::createFromFormat('Y-m-d\TH:i:s', $request->expireddate);
             //$p = Product::create($request->all());
             //Product::where("id",$p->id)->update(['expired_date' => $timeToDate ,'image_src' => $image_src ,'user_id' => auth()->user()->id]);
            
             $product = new Product($request->all());
             $product->expired_date = $timeToDate;
             $product->image_src = $image_src ;
            
             $user = User::find(auth()->user()->id);
             $product = $this->mathTheDiscount($product);
             $user->products()->save($product);
             return $product;
            }

    ///==============================show one product===================================

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comments = new CommentCTR();
        $p = Product::find($id);
        if($p->views != null)
         $p->increment('views');//update(['views' => $p->views+1]);  /// if nulll it wont increment
        else
         $p->update(['views' => $p->views+1]); 
         // $p->increment('views');
        // $p->save();
        //$p = Product::;
        $p["likes"] = $p->likes()->count();
        if($p->likes()->where('user_like', auth()->user()->email)->exists())
            $p["didILikeThis"] = true;
        else
            $p["didILikeThis"] = false;
        return response([
            'product' => $p ,
            'comments'=> $comments->showComments($id)
        ]);
    }

    ///==============================like a product===================================

    public function like($id)
    {
          $p = Product::find($id);
        //   if($p->likes != null)
        //     $p->increment('likes');
        //   else
        //      $p->update(['likes' => $p->likes+1]);
        
        $user = auth()->user()->email;
        if($p->likes()->where('user_like', $user)->exists())
            {
                //return $p->likes()->where('user_like', $user)->get();
                $p->likes()->delete();
                $message = 'you have disLiked the product';
            }
        else{
                $like = new Like();
                $like->user_like = auth()->user()->email;
                $p->likes()->save($like);
                $message = 'you have liked the product';
            }
        return response([
            'likes' => $p->likes()->count(),
            'message' => $message 
        ]);
    }

    ///==============================update product===================================
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $p = Product::find($id);
        $p->update($request->all());
        return $p;

    }
    ///==============================delete product===================================

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Product::destroy($id); 
    }
    
    ///==============================search product name===================================

    // DB::table('products')->where('id',$id)->delete();
    //  and to use it use ((( use Illuminate\Support\Facades\DB; )))

    /**
     * search the specified resource from storage by name.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function searchByName($name)
    {
        return Product::where('name','like' , '%'.$name.'%')->get();


     }

    
    public function searchByExpirationDate(Request $request)
    {
        $from = $request->input("from_date");
        $to   = $request->input('to_date');
        $query= Product::where('expired_date','>=',$from)
                           ->where('expired_date','<=',$to)
                            ->get();
        if(count($query)>=1)
        return response()->json($query);
        return response([
            'message' => 'there is no products with such date !!'
        ]);                    
      
    }

    public function searchByCatagory(Request $request)
    {
        $catagory = $request->input("catagory");
        $products = Product::where('catagory',$catagory)->get(); //// ->value(soem) ony 1 c
        if(count($products)>=1)
        //return response()->json($products);
        return Product::pluck('catagory');
        return response([
            'message' => 'there is no products with such catagory yet !! pls try later ..'
        ]);                    
    }
    // public function searchProduct(Request $request)
    // {
    //     if($request->catagory != null)
    //       { $p = Product::where('catagory',$request->catagory)->get();
    //         if()
    //         return $p; }
    //         ////// hasnt finished yet
    // }

    public function showAllUserProducts(){
        $user = User::find(auth()->user()->id);
        $products = $user->products()->get();
        return $products;
    }
    
    public function mathTheDiscount($product)
    {
        $price = $product->price;
        $expiredAt = $product->expired_date;
        $expiredAtT = strtotime($expiredAt);
        $value = ($expiredAtT - time())/(60*60*24) ;
        $value = floor($value);     
        if( $value >= 30 & $value <= 40)
        {
            $product->discounted_price = $price - (($price * $product->fifty_thirty)/100);
        }
        elseif($value >= 15 & $value < 30)
        {
            $product->discounted_price = $price - (($price * $product->thirty_fifteen)/100);
        }
        elseif($value > 0 & $value < 15)
        {
            $product->discounted_price = $price - (($price * $product->fifteen_zero)/100);
        }
        else{
            $product->discounted_price = $product->price ;
        }
        return $product;
    }
}
