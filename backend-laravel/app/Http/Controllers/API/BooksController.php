<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Book;
use MeiliSearch\Endpoints\Indexes;
use Illuminate\Database\Eloquent\Builder;
use Validator;
use App\Http\Resources\BookResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth; 
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Facades\URL;

class BooksController extends BaseController
{
    /**
     * Display a listing of the books.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        $books = Book::search(($request->get('query')) ?? '')->paginate(10)->withQueryString();
        return $this->sendResponse(['totalCount'=>$books->total(),'books'=>BookResource::collection($books),'isLogedIn'=>  $user ? true : false,'isAdmin' => $user ? $user->isAdmin : false], 'Books retrieved successfully.');
    }
    /**
     * Store a newly created book in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'author' => 'required|max:50',
            'publisher' => 'required|max:100',
            'description' => 'required',
            'genre' => 'required',
            'isbn' => 'required|numeric|digits: 13',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'published' => 'required|date'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $path = $request->file('image')->store('images', 'public');

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->description = $request->description;
        $book->genre = $request->genre;
        $book->isbn = $request->isbn;
        $book->image = asset('storage/' . $path);
        $book->published = $request->published;
        $book->save();
        return $this->sendResponse(new BookResource($book), 'Book added successfully.');
    } 
   
    /**
     * Display the specified book.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $book = Book::find($id);
  
        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }
   
        return $this->sendResponse(new BookResource($book), 'Book retrieved successfully.');
    }
    
    /**
     * Update the specified book details in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'author' => 'required|max:50',
            'publisher' => 'required|max:100',
            'description' => 'required',
            'genre' => 'required',
            'isbn' => 'required|numeric|digits: 13',
            'published' => 'required|date'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        if($request->has('image')){
            $path = $request->file('image')->store('images', 'public');
        }
        $book = Book::where('id',$id)->first();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->description = $request->description;
        $book->genre = $request->genre;
        $book->isbn = $request->isbn;
        $book->image = $request->has('image') ? asset('storage/' . $path): $book->image;
        $book->published = $request->published;
        $book->save();
        return $this->sendResponse(new BookResource($book), 'Book details updated successfully.');
    }
   
    /**
     * Remove the specified book from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        $book = Book::where('id',$id)->first();
        $book->delete();
        return $this->sendResponse([], 'Book removed successfully.');
    }
}
