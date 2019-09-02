@for ($i = 0; $i < count($images); $i++)
<div class="content-book">
   <h5 class="header-content-book"></h5>
   <div class="book-img">
      <div class="zoom">
         <span class="lupe-icon plus"></span>
      </div>
      @if (preg_match('/books/', $currentUrl))
         <img src="{!! url('images/' . lcfirst($category) . '/' . $subfolders[$i]) !!}" class="images"/>
      @else
         <img src="{!! url('images/' . lcfirst($category) . '/' . $images[$i]) !!}" class="images"/>
      @endif
      <div class="title"><span class="title-book"><b><p>{!! Str::limit($titles[$i], 60, ' ... ') !!}</p></b></span></div>
   </div>
   @if ($currentUrl === '/ResoSystem/books' || preg_match('/page/', $currentUrl))
      <div class="price"><p>{{ $books[$i]['price'] . " zł" }}</p></div>
      <div class="add-cart-btn-box-zone">
         <a href="{{ route('reso.addToCart', [$books[$i] , "book"]) }}" class="link-add-cart" role="button"><p>Add To Cart</p></a>
      </div>
   @elseif ($currentUrl === '/ResoSystem/movies')
      <div class="price"><p>{{ $movies[$i]->price . " zł" }}</p></div>
      <div class="add-cart-btn-box-zone">
         <a href="{{ route('reso.addToCart', [$movies[$i]->id , "movie"]) }}" class="link-add-cart" role="button"><p>Add To Cart</p></a>
      </div>
   @elseif ($currentUrl === '/ResoSystem/musics')
      <div class="price"><p>{{ $musics[$i]->price . " zł" }}</p></div>
      <div class="add-cart-btn-box-zone">
         <a href="{{ route('reso.addToCart', [$musics[$i]->id , "music"]) }}" class="link-add-cart" role="button"><p>Add To Cart</p></a>
      </div>
   @endif
</div>
@endfor



